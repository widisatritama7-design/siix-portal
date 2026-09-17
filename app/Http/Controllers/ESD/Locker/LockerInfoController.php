<?php

namespace App\Http\Controllers\ESD\Locker;

use App\Http\Controllers\Controller;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use App\Models\ESD\Locker\Locker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ESD\LockerNotificationMail;
use Illuminate\Support\Facades\Log;

class LockerInfoController extends Controller
{
    /**
     * Display the locker information page.
     */
    public function index()
    {
        $lockers = Locker::orderBy('code')->get();
        return view('livewire.esd.locker.locker-info-new', compact('lockers'));
    }

    /**
     * Check NIK for Store
     */
    public function checkStoreNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20|exists:tb_hr_employee,nik',
            'email' => 'required|email|max:100'
        ], [
            'nik.exists' => 'NIK not found in database',
            'email.email' => 'Email format is invalid',
            'email.required' => 'Email is required'
        ]);

        $employee = Employee::where('nik', $request->nik)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee data not found!'
            ]);
        }

        // Cek apakah karyawan sudah ada transaksi aktif
        $activeTransaction = UniformTransaction::where('employee_id', $employee->id)
            ->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
            ->first();

        if ($activeTransaction) {
            return response()->json([
                'success' => false,
                'message' => 'You still have an active transaction!'
            ]);
        }

        return response()->json([
            'success' => true,
            'employee' => [
                'nik' => $employee->nik,
                'name' => $employee->name,
                'department' => $employee->department,
                'email' => $request->email
            ]
        ]);
    }

    /**
     * Process Store Uniform
     */
    public function storeUniform(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|exists:tb_hr_employee,nik',
            'email' => 'required|email'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $employee = Employee::where('nik', $request->nik)->first();
                
                // Cari locker available
                $locker = Locker::available()->inRandomOrder()->first();

                if (!$locker) {
                    throw new \Exception('Sorry, all lockers are full!');
                }

                $email = $request->email;

                $transaction = UniformTransaction::create([
                    'employee_id' => $employee->id,
                    'email' => $email,
                    'locker_id' => $locker->id,
                    'type' => 'store',
                    'status' => 'pending'
                ]);

                $transaction->generateAccessCode();

                // Update locker status
                $locker->update([
                    'status' => 'open',
                    'employee_id' => $employee->id,
                    'locked_until' => now()->addSeconds(15),
                    'is_open' => true,
                    'opened_at' => now()
                ]);

                // Kirim Email
                $this->sendStoreEmail($transaction, $employee);

                // Dispatch Auto Close Job
                dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));

                // Store data in session for success page
                session([
                    'locker_code' => $locker->code,
                    'access_code' => $transaction->access_code
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Locker opened successfully!',
                'locker_code' => session('locker_code'),
                'access_code' => session('access_code')
            ]);

        } catch (\Exception $e) {
            Log::error('Store uniform error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check Access Code for Take
     */
    public function checkTakeCode(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string|max:50'
        ]);

        $transaction = UniformTransaction::where('access_code', $request->access_code)
            ->where('status', 'waiting_pickup')
            ->with(['employee', 'locker'])
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid access code or uniform not ready!'
            ]);
        }

        return response()->json([
            'success' => true,
            'transaction' => [
                'id' => $transaction->id,
                'nik' => $transaction->employee->nik,
                'name' => $transaction->employee->name,
                'department' => $transaction->employee->department,
                'locker_code' => $transaction->locker->code,
                'locker_status' => $transaction->locker->status
            ]
        ]);
    }

    /**
     * Process Take Uniform
     */
    public function takeUniform(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $transaction = UniformTransaction::where('access_code', $request->access_code)
                    ->where('status', 'waiting_pickup')
                    ->with(['employee', 'locker'])
                    ->first();

                if (!$transaction) {
                    throw new \Exception('Invalid access code!');
                }

                $locker = $transaction->locker;

                // Buka locker
                $locker->update([
                    'locked_until' => now()->addSeconds(15),
                    'is_open' => true,
                    'opened_at' => now()
                ]);

                // Update transaksi
                $transaction->update([
                    'status' => 'completed',
                    'taken_at' => now()
                ]);

                // Kosongkan employee_id
                $locker->update([
                    'employee_id' => null
                ]);

                // Kirim Email
                $this->sendTakeEmail($transaction);

                // Dispatch Auto Close
                dispatch(new \App\Jobs\AutoCloseLockerJob($locker->id))->delay(now()->addSeconds(15));

                session(['locker_code' => $locker->code]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Locker opened successfully!',
                'locker_code' => session('locker_code')
            ]);

        } catch (\Exception $e) {
            Log::error('Take uniform error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send Email for Store
     */
    protected function sendStoreEmail($transaction, $employee)
    {
        try {
            $email = $transaction->email;

            if (!$email) {
                Log::error('No email for Store notification', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }

            $data = [
                'employee_name' => $employee->name,
                'nik' => $employee->nik,
                'locker_code' => $transaction->locker->code,
                'access_code' => $transaction->access_code,
                'type' => 'store',
                'status' => 'Menunggu Pengecekan',
                'datetime' => now()->format('d/m/Y H:i')
            ];

            Mail::to($email)->send(new LockerNotificationMail($data));
            
            Log::info('Store Email sent successfully', [
                'transaction_id' => $transaction->id,
                'email' => $email
            ]);
        } catch (\Exception $e) {
            Log::error('Store Email send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    /**
     * Send Email for Take
     */
    protected function sendTakeEmail($transaction)
    {
        try {
            $employee = $transaction->employee;
            $email = $transaction->email;

            if (!$email) {
                Log::error('No email for Take notification', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }

            $data = [
                'employee_name' => $employee->name,
                'nik' => $employee->nik,
                'locker_code' => $transaction->locker->code,
                'type' => 'take',
                'status' => 'Selesai Diambil',
                'datetime' => now()->format('d/m/Y H:i')
            ];

            Mail::to($email)->send(new LockerNotificationMail($data));
            
            Log::info('Take Email sent successfully', [
                'transaction_id' => $transaction->id,
                'email' => $email
            ]);
        } catch (\Exception $e) {
            Log::error('Take Email send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }
}
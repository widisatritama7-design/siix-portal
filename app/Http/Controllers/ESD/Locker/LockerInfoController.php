<?php

namespace App\Http\Controllers\ESD\Locker;

use App\Http\Controllers\Controller;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use App\Models\ESD\Locker\Locker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WhatsAppService;
use App\Helpers\PhoneHelper;
use Illuminate\Support\Facades\Log;

class LockerInfoController extends Controller
{
    /**
     * Display the locker information page.
     */
    public function index()
    {
        $lockers = Locker::orderBy('code')->get();
        return view('esd.locker.info', compact('lockers'));
    }

    /**
     * Check NIK for Store
     */
    public function checkStoreNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20|exists:tb_hr_employee,nik',
            'phone' => 'required|string|max:20|regex:/^[0-9]{10,15}$/'
        ], [
            'nik.exists' => 'NIK not found in database',
            'phone.regex' => 'WhatsApp number must be 10-15 digits'
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
                'phone' => $request->phone
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
            'phone' => 'required|string'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $employee = Employee::where('nik', $request->nik)->first();
                
                // Cari locker available
                $locker = Locker::available()->inRandomOrder()->first();

                if (!$locker) {
                    throw new \Exception('Sorry, all lockers are full!');
                }

                $formattedPhone = PhoneHelper::formatToInternational($request->phone);

                $transaction = UniformTransaction::create([
                    'employee_id' => $employee->id,
                    'phone' => $formattedPhone,
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

                // Kirim WhatsApp
                $this->sendStoreWhatsApp($transaction, $employee);

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

                // Kirim WhatsApp
                $this->sendTakeWhatsApp($transaction);

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
     * Send WhatsApp for Store
     */
    protected function sendStoreWhatsApp($transaction, $employee)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $phone = $transaction->phone;

            if (!$phone) {
                Log::error('No phone number for WhatsApp Store', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }

            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "✅ Anda telah menyimpan seragam di locker *{$transaction->locker->code}*\n\n";
            $message .= "📋 *Detail Transaksi:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$transaction->locker->code}\n";
            $message .= "• Status: Menunggu Pengecekan\n\n";
            $message .= "⏳ Seragam Anda akan segera diperiksa oleh tim ESD.\n";
            $message .= "Anda akan mendapat notifikasi setelah selesai.\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            $whatsapp->send($phone, $message);
            
            Log::info('WhatsApp Store sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp Store send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }

    /**
     * Send WhatsApp for Take
     */
    protected function sendTakeWhatsApp($transaction)
    {
        try {
            $whatsapp = app(WhatsAppService::class);
            $employee = $transaction->employee;
            $phone = $transaction->phone;

            if (!$phone) {
                Log::error('No phone number for WhatsApp Take', [
                    'transaction_id' => $transaction->id
                ]);
                return;
            }

            $message = "*ESD Locker System*\n\n";
            $message .= "Halo *{$employee->name}*,\n\n";
            $message .= "✅ Anda telah mengambil seragam dari locker *{$transaction->locker->code}*\n\n";
            $message .= "📋 *Detail Transaksi:*\n";
            $message .= "• NIK: {$employee->nik}\n";
            $message .= "• Locker: {$transaction->locker->code}\n";
            $message .= "• Waktu: " . now()->format('d/m/Y H:i') . "\n";
            $message .= "• Status: Selesai Diambil\n\n";
            $message .= "Terima kasih telah menggunakan layanan ESD.\n";
            $message .= "_Pesan ini dikirim otomatis oleh sistem._";

            $whatsapp->send($phone, $message);
            
            Log::info('WhatsApp Take sent successfully', [
                'transaction_id' => $transaction->id,
                'phone' => $phone
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp Take send failed: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id
            ]);
        }
    }
}
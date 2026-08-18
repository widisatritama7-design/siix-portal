<?php

namespace App\Http\Controllers\ESD;

use App\Http\Controllers\Controller;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use App\Models\ESD\Locker\Locker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LockerController extends Controller
{
    public function getLockers()
    {
        $lockers = Locker::orderBy('code')->get();
        return response()->json($lockers);
    }

    public function checkNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20|exists:tb_hr_employee,nik'
        ]);

        $employee = Employee::where('nik', $request->nik)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ]);
        }

        // Check active transaction
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
            'employee' => $employee
        ]);
    }

    public function storeUniform(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|exists:tb_hr_employee,nik'
        ]);

        $employee = Employee::where('nik', $request->nik)->first();

        return DB::transaction(function () use ($employee) {
            $locker = Locker::available()->inRandomOrder()->first();

            if (!$locker) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, all lockers are full!'
                ]);
            }

            $transaction = UniformTransaction::create([
                'employee_id' => $employee->id,
                'locker_id' => $locker->id,
                'type' => 'store',
                'status' => 'pending'
            ]);

            $transaction->generateAccessCode();

            $locker->update([
                'status' => 'open',
                'employee_id' => $employee->id,
                'locked_until' => now()->addSeconds(15)
            ]);

            return response()->json([
                'success' => true,
                'locker_code' => $locker->code,
                'access_code' => $transaction->access_code
            ]);
        });
    }

    public function checkTake(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50'
        ]);

        $transaction = UniformTransaction::where('access_code', $request->code)
            ->whereIn('status', ['pending', 'waiting_pickup'])
            ->where('expires_at', '>', now())
            ->with(['employee', 'locker'])
            ->first();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid access code or expired!'
            ]);
        }

        if ($transaction->locker->isLocked()) {
            return response()->json([
                'success' => false,
                'message' => 'Locker is locked, please wait a moment!'
            ]);
        }

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

    public function openTakeLocker(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:tb_esd_uniform_transaction,id'
        ]);

        $transaction = UniformTransaction::find($request->transaction_id);

        return DB::transaction(function () use ($transaction) {
            $locker = $transaction->locker;

            $locker->update([
                'locked_until' => now()->addSeconds(15)
            ]);

            $transaction->update([
                'status' => 'completed',
                'taken_at' => now()
            ]);

            $locker->update([
                'status' => 'available',
                'employee_id' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Locker opened successfully!'
            ]);
        });
    }
}
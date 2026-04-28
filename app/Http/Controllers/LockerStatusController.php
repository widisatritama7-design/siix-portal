<?php

namespace App\Http\Controllers;

use App\Models\ESD\Locker\LockerStatus;
use App\Models\HR\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockerStatusController extends Controller
{
    public function index()
    {
        $lockers = LockerStatus::orderBy('locker_number')->get();

        $employees = Employee::select('nik as nik', 'name as name', 'department as dept')->get();

        return view('livewire.esd.locker.locker-status', compact('lockers', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'locker_number' => 'required|integer|min:1|max:20|unique:locker_statuses,locker_number',
            'nik' => 'nullable|string',
            'name' => 'nullable|string',
            'dept' => 'nullable|string',
            'status' => 'required|in:Available,Filled,On Process Measure,Finish',
        ]);

        LockerStatus::create([
            'locker_number' => $request->locker_number,
            'nik' => $request->nik,
            'name' => $request->name,
            'dept' => $request->dept,
            'status' => $request->status,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Locker status added.');
    }

    // Update by locker_number via AJAX
    public function update(Request $request)
    {
        $request->validate([
            'locker_number' => 'required|integer|min:1|max:20',
            'nik' => 'nullable|string',
            'name' => 'nullable|string',
            'dept' => 'nullable|string',
            'status' => 'required|in:Available,Filled,On Process Measure,Finish',
        ]);

        // Cari data berdasar locker_number
        $lockerStatus = LockerStatus::where('locker_number', $request->locker_number)->first();

        if ($lockerStatus) {
            $lockerStatus->update([
                'nik' => $request->nik,
                'name' => $request->name,
                'dept' => $request->dept,
                'status' => $request->status,
                'updated_by' => Auth::id(),
            ]);
        } else {
            // Jika belum ada data, buat baru
            LockerStatus::create([
                'locker_number' => $request->locker_number,
                'nik' => $request->nik,
                'name' => $request->name,
                'dept' => $request->dept,
                'status' => $request->status,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        // Kalau ini dipanggil dari AJAX, balas JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Locker status updated.']);
        }

        return redirect()->back()->with('success', 'Locker status updated.');
    }

    public function getEmployee($nik)
    {
        $employee = Employee::where('nik', $nik)->first();

        if ($employee) {
            return response()->json([
                'success' => true,
                'name' => $employee->name,
                'dept' => $employee->department,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not found',
        ], 404);
    }

    public function getLockerData()
    {
        $lockers = LockerStatus::all(); // atau query lain sesuai kebutuhan
        return response()->json(['lockers' => $lockers]);
    }


}

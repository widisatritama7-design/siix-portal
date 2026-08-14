<?php

namespace App\Models\HR;

use App\Models\ESD\Locker\Locker;
use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\EmployeeCall;
use App\Models\HR\ViolationEmployee;
use App\Models\PROD\Absence\AbsenceControl;
use App\Models\PROD\Absence\AbsenceReport;
use App\Models\PROD\Uniform\UniformRequest;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'tb_hr_employee';

    protected $fillable = [
        'id',
        'nik',
        'name',
        'department',
        'email',
        'status',
        'contract_date',
        'in_date',
        'last_group',
        'last_job',
        'last_route',
        'photo',
        'actual_group',
        'actual_section',
        'actual_process',
        'actual_route',
        'actual_titik_jemputan',
        'actual_shift',
        'actual_status',
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function setAttribute($key, $value)
    {
        return null;
    }

    public function esdUniformTransactions()
    {
        return $this->hasMany(UniformTransaction::class, 'employee_id', 'id');
    }

    public function esdLockers()
    {
        return $this->hasMany(Locker::class, 'employee_id', 'id');
    }

    public function getLatestEsdTransaction()
    {
        return $this->esdUniformTransactions()
                    ->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
                    ->latest()
                    ->first();
    }

    public function hasActiveEsdTransaction()
    {
        return $this->esdUniformTransactions()
                    ->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
                    ->exists();
    }

    public function comelateEmployees()
    {
        return $this->hasMany(ComelateEmployee::class, 'nik', 'id');
    }

    public function violationEmployees()
    {
        return $this->hasMany(ViolationEmployee::class, 'nik', 'id');
    }

    public function employeeCalls()
    {
        return $this->hasMany(EmployeeCall::class, 'nik', 'id');
    }

    public function uniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'employee_id', 'id');
    }

    public function pendingUniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'employee_id', 'id')->where('status', 'pending');
    }

    public function approvedUniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'employee_id', 'id')->where('status', 'approved');
    }

    public function receivedUniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'employee_id', 'id')->where('status', 'received');
    }

    public function rejectedUniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'employee_id', 'id')->where('status', 'rejected');
    }

    public function absenceReports()
    {
        return $this->hasMany(AbsenceReport::class, 'employee_id');
    }

    public function absenceControls()
    {
        return $this->hasMany(AbsenceControl::class, 'employee_id', 'id');
    }

    public function getAbsenceControlsByDateRange($startDate, $endDate)
    {
        return $this->absenceControls()
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();
    }
}
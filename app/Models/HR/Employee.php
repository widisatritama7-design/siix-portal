<?php

namespace App\Models\HR;

use App\Models\HR\EmployeeCall;
use App\Models\HR\ViolationEmployee;
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
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function setAttribute($key, $value)
    {
        return null;
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
}
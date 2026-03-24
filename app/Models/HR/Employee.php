<?php

namespace App\Models\HR;

use App\Models\HR\EmployeeCall;
use App\Models\HR\ViolationEmployee;
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

    public function employeeCall()
    {
        return $this->hasMany(EmployeeCall::class, 'nik', 'id');
    }
}
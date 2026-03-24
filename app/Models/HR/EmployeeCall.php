<?php

namespace App\Models\HR;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeCall extends Model
{
    use HasFactory;

    protected $table = 'tb_hr_employee_calls';

    protected $fillable = [
        'nik',
        'category',
        'date_call',
        'time_call',
    ];

    public $timestamps = true;

    protected $casts = [
        'date_call' => 'date',
        'time_call' => 'datetime:H:i:s',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}

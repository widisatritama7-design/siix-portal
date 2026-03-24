<?php

namespace App\Models\HR;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ViolationEmployee extends Model
{
    use HasFactory;

    protected $table = 'tb_hr_violation_employees';

    protected $fillable = [
        'nik',
        'name',
        'dept',
        'shift',
        'category',
        'sub_category',
        'plat_motor',
        'security_name',
        'alasan',
        'remarks',
        'photo',
        'date',
    ];
    
    protected $casts = [
        'sub_category' => 'array',
        'date' => 'date',
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
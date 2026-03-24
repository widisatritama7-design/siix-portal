<?php

namespace App\Models\HR;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ComelateEmployee extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tb_hr_comelate_employees';

    protected $fillable = [
        'nik', 
        'name', 
        'department', 
        'shift', 
        'status',
        'alasan_terlambat', 
        'nama_security', 
        'tanggal', 
        'jam',
        'jam_masuk',
        'count_jam',
        'remarks'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // FIXED: Match nik in comelate table (which stores employee ID) to employee id
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'id');
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

        static::addGlobalScope('withEmployee', function (Builder $builder) {
            $builder->with('employee');
        });
    }
}
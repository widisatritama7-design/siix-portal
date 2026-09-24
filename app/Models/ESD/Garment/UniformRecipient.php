<?php

namespace App\Models\ESD\Garment;

use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Model;

class UniformRecipient extends Model
{
    protected $table = 'tb_esd_uniform_recipients';
    
    protected $fillable = [
        'employee_id',
        'nik',
        'name',
        'email',
        'department',
        'date_measure',   // ← tambah
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'date_measure' => 'date',   // ← tambah
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
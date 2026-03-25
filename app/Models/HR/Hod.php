<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Hod extends Model
{
    protected $table = 'tb_hr_hod';

    protected $fillable = [
        'id',
        'department_name',
        'hod_id',
        'hod_name',
        'hod_email',
    ];
}

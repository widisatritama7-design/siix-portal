<?php

namespace App\Models\ESD\Activity;

use Illuminate\Database\Eloquent\Model;

class ViewAllMeasurement extends Model
{
    protected $table = 'view_all_measurement';

    public $timestamps = false;

    protected $primaryKey = 'id_table';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'measurement_type',
        'id_table',
        'next_date',
        'created_at'
    ];
}

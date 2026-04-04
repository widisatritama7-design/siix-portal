<?php

namespace App\Models\ESD\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_events';

    protected $fillable = [
        'title',
        'description',
        'file',
        'color',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'file' => 'array',
    ];

}

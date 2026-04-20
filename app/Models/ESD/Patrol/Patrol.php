<?php

namespace App\Models\ESD\Patrol;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patrol extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_patrols';

    protected $fillable = [
        'area',
        'location',
        'v_1',
        'v_2',
        'v_3',
        'judgement_v3',
        'v_4',
        'remarks',
        'next_date',
        'created_by',
    ];

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

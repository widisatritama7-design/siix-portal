<?php

namespace App\Models\ESD\WS;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WristStrap extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_wrist_straps';

    protected $fillable = [
        'register_no',
        'result',
        'result_scientific',
        'judgement',
        'remarks',
        'type',
        'next_date',
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

<?php

namespace App\Models\ESD\Insulatif;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsulatifCheck extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_insulatif_checks';

    protected $fillable = [
        'register_no',
        'result',
        'result_scientific',
        'judgement',
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

<?php

namespace App\Models\ESD\Shower;

use App\Models\ESD\Shower\Shower;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShowerDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_shower_details';

    protected $fillable = [
        'shower_id',
        'check_body',
        'velocity',
        'judgement',
        'created_by',
        'updated_by',
        'next_date',
        'remarks',
        'created_by',

    ];

    public function shower()
    {
        return $this->belongsTo(Shower::class);
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

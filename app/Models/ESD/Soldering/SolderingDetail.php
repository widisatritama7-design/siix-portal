<?php

namespace App\Models\ESD\Soldering;

use App\Models\ESD\Soldering\Soldering;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SolderingDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_soldering_details';

    protected $fillable = [
        'soldering_id',
        'e1',
        'judgement',
        'next_date',
        'created_by',
        'updated_by',
    ];

    public function soldering()
    {
        return $this->belongsTo(Soldering::class);
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
            if (empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}

<?php

namespace App\Models\ESD\Glove;

use App\Models\ESD\Glove\Glove;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GloveDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_glove_details';

    protected $fillable = [
        'glove_id',
        'c1',
        'c1_scientific',
        'judgement',
        'remarks',
        'next_date'
    ];

    public function glove()
    {
        return $this->belongsTo(Glove::class);
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

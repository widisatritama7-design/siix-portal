<?php

namespace App\Models\ESD\Flooring;

use App\Models\ESD\Flooring\Flooring;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FlooringDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_flooring_details';

    protected $fillable = ['flooring_id', 'area', 'location', 'b1', 'b1_scientific', 'judgement', 'remarks', 'next_date', 'created_by'];

    public function flooring()
    {
        return $this->belongsTo(Flooring::class);
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
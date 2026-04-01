<?php

namespace App\Models\ESD\Worksurface;

use App\Models\ESD\Worksurface\Worksurface;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorksurfaceDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_worksurface_details';

    protected $fillable = [
        'worksurface_id',
        'area',
        'location',
        'item',
        'a1',
        'a1_scientific',
        'judgement_a1',
        'a2',
        'judgement_a2',
        'remarks',
        'created_at',
        'next_date'
    ];

    public function worksurface()
    {
        return $this->belongsTo(Worksurface::class);
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

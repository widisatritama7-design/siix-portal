<?php

namespace App\Models\ESD\Worksurface;

use App\Models\ESD\Worksurface\WorksurfaceDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Worksurface extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_worksurfaces';

    protected $fillable =['register_no','area','location', 'status', 'layer_count', 'category']; 

    public function worksurfaceDetails()
    {
        return $this->hasMany(WorksurfaceDetail::class);
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

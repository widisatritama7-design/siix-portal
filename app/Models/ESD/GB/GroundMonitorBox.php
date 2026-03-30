<?php

namespace App\Models\ESD\GB;

use App\Models\ESD\GB\GroundMonitorBoxDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroundMonitorBox extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_ground_monitor_boxs';
    
    protected $fillable =['register_no','area','location', 'status'];

    public function groundMonitorBoxDetails()
    {
        return $this->hasMany(GroundMonitorBoxDetail::class);
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

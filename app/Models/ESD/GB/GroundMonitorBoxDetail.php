<?php

namespace App\Models\ESD\GB;

use App\Models\ESD\GB\GroundMonitorBox;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroundMonitorBoxDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_ground_monitor_box_details';

    protected $fillable = [
        'ground_monitor_box_id',
        'g_3',
        'g_4',
        'remarks',
        'next_date',
        'created_by',
    ];

    public function groundMonitorBox()
    {
        return $this->belongsTo(GroundMonitorBox::class);
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

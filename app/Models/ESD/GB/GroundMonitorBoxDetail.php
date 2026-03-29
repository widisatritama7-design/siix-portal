<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroundMonitorBoxDetail extends Model 
{
    use HasFactory;

    protected $connection = 'mysql_esd';

    protected $fillable = [
        'ground_monitor_box_id',
        'area',
        'location',
        'g1',
        'g2',
        'g_3',
        'g_4',
        'remarks',
        'next_date'
    ];

    public function groundMonitorBox()
    {
        return $this->belongsTo(GroundMonitorBox::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the transaction.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Boot method to attach model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        });

        // Set the updater on updating event
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}

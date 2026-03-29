<?php

namespace App\Models;

use App\Models\User;

use App\Models\ActivityLog;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroundMonitorBox extends Model 
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd';
    
    protected $fillable =['register_no','area','location', 'status'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['register_no','area','location', 'status']);
    }

    public function groundMonitorBoxDetails()
    {
        return $this->hasMany(GroundMonitorBoxDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $yesCount = GroundMonitorBoxDetail::where('ground_monitor_box_id', $this->id)
                    ->where(function($query) {
                        $query->where('g1', 'YES')
                            ->orWhere('g2', 'YES');
                    })
                    ->count();

        $noCount = GroundMonitorBoxDetail::where('ground_monitor_box_id', $this->id)
                    ->where(function($query) {
                        $query->where('g1', 'NO')
                            ->orWhere('g2', 'NO');
                    })
                    ->count();

        return [
            'yes' => $yesCount,
            'no' => $noCount,
        ];
    }

    public function activityLog()
    {
        return $this->hasMany(ActivityLog::class, 'subject_id', 'id');
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

        // Set the creator on creating event
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        // Set the updater on updating event
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}

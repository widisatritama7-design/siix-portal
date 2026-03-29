<?php

namespace App\Models;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\WorksurfaceDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worksurface extends Model 
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd';

    protected $fillable =['register_no','area','location', 'status', 'layer_count', 'category'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'register_no','area','location', 'status', 'layer_count', 'category'
        ]);
    }

    public function activityLog()
    {
        return $this->hasMany(ActivityLog::class, 'subject_id', 'id');
    }    

    public function worksurfaceDetails()
    {
        return $this->hasMany(WorksurfaceDetail::class);
    }

    // public function getJudgementCountsAttribute()
    // {
    //     $okCount = WorksurfaceDetail::where('worksurface_id', $this->id)
    //                 ->where(function($query) {
    //                     $query->where('judgement_a1', 'OK')
    //                         ->orWhere('judgement_a2', 'OK');
    //                 })
    //                 ->count();

    //     $ngCount = WorksurfaceDetail::where('worksurface_id', $this->id)
    //                 ->where(function($query) {
    //                     $query->where('judgement_a1', 'NG')
    //                         ->orWhere('judgement_a2', 'NG');
    //                 })
    //                 ->count();

    //     return [
    //         'ok' => $okCount,
    //         'ng' => $ngCount,
    //     ];
    // }

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

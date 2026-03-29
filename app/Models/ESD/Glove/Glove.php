<?php

namespace App\Models;

use App\Models\User;

use App\Models\ActivityLog;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Glove extends Model 
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd';
    
    protected $fillable =['sap_code','description','delivery' , 'status'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['sap_code','description','delivery' , 'status']);
    }

    public function gloveDetails()
    {
        return $this->hasMany(GloveDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = GloveDetail::where('glove_id', $this->id)->where('judgement', 'OK')->count();
        $ngCount = GloveDetail::where('glove_id', $this->id)->where('judgement', 'NG')->count();

        return [
            'ok' => $okCount,
            'ng' => $ngCount
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

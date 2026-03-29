<?php

namespace App\Models;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\IonizerDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ionizer extends Model 
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd';

    protected $fillable =['register_no','area','location', 'status','gap'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['register_no','area','location', 'status', 'gap']);
    }

    public function ionizerdetails()
    {
        return $this->hasMany(IonizerDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = IonizerDetail::where('ionizer_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_c1', 'OK')
                            ->orWhere('judgement_c2', 'OK')
                            ->orWhere('judgement_c3', 'OK');
                    })
                    ->count();

        $ngCount = IonizerDetail::where('ionizer_id', $this->id)
                    ->where(function($query) {
                        $query->where('judgement_c1', 'NG')
                            ->orWhere('judgement_c2', 'NG')
                            ->orWhere('judgement_c3', 'NG');
                    })
                    ->count();

        return [
            'ok' => $okCount,
            'ng' => $ngCount,
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

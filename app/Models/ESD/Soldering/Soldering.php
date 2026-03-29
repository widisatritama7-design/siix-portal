<?php

namespace App\Models;

use App\Models\User;

use App\Models\ActivityLog;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Soldering extends Model 
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd';
    
    protected $fillable =['register_no','area','location', 'status', 'type', 'spec', 'line', 'running_customer', 'last_measured'];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['register_no','area','location', 'status', 'type', 'spec', 'line', 'running_customer', 'last_measured']);
    }

    public function solderingDetails()
    {
        return $this->hasMany(SolderingDetail::class);
    }

    public function getJudgementCountsAttribute()
    {
        $okCount = SolderingDetail::where('soldering_id', $this->id)->where('judgement', 'OK')->count();
        $ngCount = SolderingDetail::where('soldering_id', $this->id)->where('judgement', 'NG')->count();

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
    
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });
    
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    
        // Tambah event setelah create & update
        static::saved(function ($detail) {
            $soldering = $detail->soldering;
        
            if ($soldering) {
                $soldering->update([
                    'spec' => $detail->spec,
                    'line' => $detail->line,
                    'running_customer' => $detail->running_customer,
                    'last_measured' => $detail->created_at,// Atau $detail->created_at jika kamu ingin tanggal aslinya
                ]);
            }
        });
        
    }
    
}

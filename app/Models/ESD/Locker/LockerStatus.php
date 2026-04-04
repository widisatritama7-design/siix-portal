<?php

namespace App\Models\ESD\Locker;

use App\Models\User;
use Spatie\Activitylog\Support\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LockerStatus extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'tb_esd_locker_statuses';

    protected $fillable = [
        'locker_number',
        'nik',
        'name',
        'dept',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'locker_number',
            'nik',
            'name',
            'dept',
            'status',
            'created_by',
            'updated_by',
        ]);
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

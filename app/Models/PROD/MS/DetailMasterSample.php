<?php

namespace App\Models\PROD\MS;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailMasterSample extends Model
{
    use HasFactory;
    // use LogsActivity;

    protected $table = 'tb_prod_detail_master_samples';

    public bool $skipUpdatedBy = false;

    protected $fillable = [
        'master_sample_id',
        'updated_date',
        'date_alarm',
        'expired_date',
        'status',
        'checked_by',
        'approved_by',
        'knowladge_by',
        'created_by',
        'updated_by',
        'check_date',
        'knowladge_date',
        'approve_date'
    ];

    protected $casts = [
        'updated_date' => 'date',
        'expired_date' => 'date',
        'date_alarm' => 'date',
        'check_date' => 'datetime',
        'knowladge_date' => 'datetime',
        'approve_date' => 'datetime',
    ];

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly([
    //             'master_sample_id',
    //             'updated_date',
    //             'date_alarm',
    //             'expired_date',
    //             'status',
    //             'checked_by',
    //             'approved_by',
    //             'knowladge_by',
    //             'created_by',
    //             'updated_by',
    //             'check_date',
    //             'knowladge_date',
    //             'approve_date'
    //         ])
    //         ->useLogName('master_sample')
    //         ->logOnlyDirty();
    // }

    public function masterSample()
    {
        return $this->belongsTo(MasterSample::class, 'master_sample_id');
    }

    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function knowladgeBy()
    {
        return $this->belongsTo(User::class, 'knowladge_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function setExpiredDateAttribute($value)
    {
        $this->attributes['expired_date'] = $value && $value !== '-' ? $value : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by ??= Auth::id();
                $model->updated_by ??= Auth::id();
            }
        });

        static::updating(function ($model) {
            if ($model->skipUpdatedBy) {
                return;
            }

            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}

<?php

namespace App\Models\PROD\MS;

use App\Models\HR\Employee;
use App\Models\MTC\Master\MasterLine;
use App\Models\PROD\MS\MasterSample;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistoryMasterSample extends Model
{
    use HasFactory;
    // use LogsActivity;

    protected $table = 'tb_prod_history_master_samples';

    protected $fillable = [
        'master_sample_id',
        'type',
        'out_date',
        'in_date',
        'qty',
        'remarks',
        'nik',
        'verification_after_return',
        'approval',
        'status',
        'master_line_id'
    ];

    protected $casts = [
        'out_date' => 'datetime',
        'in_date' => 'datetime',
        'qty' => 'string',
        'verification_after_return' => 'string',
        'approval' => 'string',
        'nik' => 'integer',
        'type' => 'array',
    ];

    public function masterSample()
    {
        return $this->belongsTo(MasterSample::class, 'master_sample_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'id');
    }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly([
    //             'master_sample_id',
    //             'type',
    //             'out_date',
    //             'in_date',
    //             'qty',
    //             'remarks',
    //             'nik',
    //             'verification_after_return',
    //             'approval',
    //             'status',
    //             'line_name'
    //         ])
    //         ->useLogName('history-master-sample')
    //         ->logOnlyDirty();
    // }

    public function masterLine()
    {
        return $this->belongsTo(MasterLine::class, 'master_line_id');
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

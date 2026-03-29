<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use App\Models\JigDetail;
use App\Models\ActivityLog;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jig extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd';
    protected $table = 'jigs';

    // Mass assignable columns
    protected $fillable = [
        'received_date',
        'registration_date',
        'register_no',
        'sek_cust_id',
        'fabricator',
        'model',
        'description',
        'application',
        'pin_qty',
        'jig_qty',
        'photo',
        'design_by',
        'qualified_date',
        'results',
        'remarks',
        'bit_size',
        'customer',
        'tooling_type',
        'category',
        'location',
        'status',
        'amount_solder',
        'rack',
        'nik',
        'rack_number',
        'line_name',
        'count_stencil',
        'created_by',
        'updated_by'
    ];

    // Date casting
    protected $dates = [
        'received_date',
        'registration_date',
        'qualified_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'photo' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'received_date',
                'registration_date',
                'register_no',
                'sek_cust_id',
                'fabricator',
                'model',
                'description',
                'application',
                'pin_qty',
                'jig_qty',
                'photo',
                'design_by',
                'qualified_date',
                'results',
                'remarks',
                'bit_size',
                'customer',
                'tooling_type',
                'category',
                'location',
                'status',
                'line_name',
                'nik',
                'count_stencil',
                'created_by',
                'updated_by'

            ])
            ->useLogName('jig')
            ->logOnlyDirty();
    }

    public function activityLog()
    {
        return $this->hasMany(ActivityLog::class, 'subject_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'ID');
    }

    public function jigDetails()
    {
        return $this->hasMany(JigDetail::class, 'jigs_id');
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

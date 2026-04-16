<?php

namespace App\Models\MTC\Master;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class MasterStencil extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'tb_esd_jigs';

    protected $fillable = [
        'register_no',
        'customer',
        'rack_number',
        'status',
        'line_name',
        'count_stencil',
        'nik',
        'received_date',
        'registration_date',
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
        'tooling_type',
        'category',
        'location',
        'amount_solder',
        'rack',
        'created_by',
        'updated_by'
    ];

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
            'register_no',
            'customer',
            'rack_number',
            'status',
            'line_name',
            'count_stencil',
            'nik',
            'received_date',
            'registration_date',
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
            'tooling_type',
            'category',
            'location',
            'amount_solder',
            'rack',
            'created_by',
            'updated_by',
            'received_date',
            'registration_date',
            'qualified_date',
            'created_at',
            'updated_at',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'id');
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
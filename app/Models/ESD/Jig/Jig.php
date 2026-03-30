<?php

namespace App\Models\ESD\Jig;

use App\Models\ESD\Jig\JigDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Jig extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_jigs';

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

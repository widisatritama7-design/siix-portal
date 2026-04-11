<?php

namespace App\Models\MTC\Master;

use App\Models\MTC\Master\MasterLine;
use App\Models\MTC\Master\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterMachine extends Model
{
    use HasFactory;

    protected $table = 'tb_mtc_master_machines';

    protected $fillable = [
        'location_id',
        'line_id',
        'name',
        'model_type',
        'mfg_date',
        'maker',
        'serial_no',
        'power_voltage',
        'power_amper',
        'no_of_phases',
        'air_supply',
        'n2_supply',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'mfg_date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(MasterLocation::class, 'location_id', 'id');
    }

    public function line()
    {
        return $this->belongsTo(MasterLine::class, 'line_id');
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

<?php

namespace App\Models\ESD\EG;

use App\Models\ESD\EG\EquipmentGround;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EquipmentGroundDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_equipment_ground_details';

    protected $fillable = [
        'equipment_ground_id',
        'area',
        'location',
        'measure_results_ohm',
        'judgement_ohm',
        'measure_results_volts',
        'judgement_volts',
        'remarks',
        'next_date',
        'created_by',
    ];

    public function equipmentGround()
    {
        return $this->belongsTo(EquipmentGround::class);
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
            if (empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

}

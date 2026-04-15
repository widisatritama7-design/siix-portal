<?php

namespace App\Models\MTC\Daily;

use App\Models\MTC\Master\MasterLine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Traits\LogsActivity;

class DailyPanasonic extends Model
{
    use HasFactory;
    // use LogsActivity;
    
    protected $table = 'tb_mtc_daily_panasonics';

    protected $fillable = [
        'master_line_id',
        'body_cover',
        'cylinder',
        'rail_and_magazine_pcb',
        'cover_magazine',
        'brush',
        'air_presure',
        'vacume_presure_unitech',
        'vacume_presure_nix',
        'vacume_brush',
        'cleaning_roller',
        'ionizer',
        'conveyor_speed',
        'ipa_solvent',
        'temperature_control_1',
        'humidity_control_1',
        'clamp_presure_sp_60',
        'clamp_presure_spg_2',
        'squeege_sp_60',
        'squeege_spg_2',
        'cleaning_solvent',
        'air_presure_meter',
        'air_presure_meter_parmi',
        'capability_index',
        'box',
        'vaccuum_parameter',
        'expire_date',
        'vaccuum_pump',
        'box_2',
        'vaccuum_parameter_2',
        'expire_date_2',
        'vaccuum_pump_2',
        'abandonment',
        'fire_posibilty',
        'rail_and_transfer_unit',
        'n2_presure',
        'oxygent_density_sek',
        'oxygent_density_special',
        'fire_posibilty_2',
        'air_presure_2',
        'cylinder_2',
        'rail_and_magazine_pcb_2',
        'cover_magazine_2',
        'angle_and_filter',
        'lamp_indicator',
        'temperature_chiller',
        'temperature_control_3',
        'air_presure_supply',
        'box_3',
        'vaccuum_pump_3',
        'air_presure_supply_2',
        'box_4',
        'vaccuum_pump_4',
        'air_presure_3',
        'temperature_control_4',
        'water_reservoirs',
        'filter',
        'angle_and_filter_2',
        'stop_time',
        'run_time',
        'approval',
        'group',
        'status',
        'approved_by'
    ];

    protected $casts = [
        'stop_time' => 'datetime:H:i:s',
        'run_time' => 'datetime:H:i:s',
    ];

    public function masterLine()
    {
        return $this->belongsTo(MasterLine::class,'master_line_id');
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

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly([
    //             'master_line_id',
    //             'body_cover',
    //             'cylinder',
    //             'rail_and_magazine_pcb',
    //             'cover_magazine',
    //             'brush',
    //             'air_presure',
    //             'vacume_presure_unitech',
    //             'vacume_presure_nix',
    //             'vacume_brush',
    //             'cleaning_roller',
    //             'ionizer',
    //             'conveyor_speed',
    //             'ipa_solvent',
    //             'temperature_control_1',
    //             'humidity_control_1',
    //             'clamp_presure_sp_60',
    //             'clamp_presure_spg_2',
    //             'squeege_sp_60',
    //             'squeege_spg_2',
    //             'cleaning_solvent',
    //             'air_presure_meter',
    //             'air_presure_meter_parmi',
    //             'capability_index',
    //             'box',
    //             'vaccuum_parameter',
    //             'expire_date',
    //             'vaccuum_pump',
    //             'box_2',
    //             'vaccuum_parameter_2',
    //             'expire_date_2',
    //             'vaccuum_pump_2',
    //             'abandonment',
    //             'fire_posibilty',
    //             'rail_and_transfer_unit',
    //             'n2_presure',
    //             'oxygent_density_sek',
    //             'oxygent_density_special',
    //             'fire_posibilty_2',
    //             'air_presure_2',
    //             'cylinder_2',
    //             'rail_and_magazine_pcb_2',
    //             'cover_magazine_2',
    //             'angle_and_filter',
    //             'lamp_indicator',
    //             'temperature_chiller',
    //             'temperature_control_3',
    //             'air_presure_supply',
    //             'box_3',
    //             'vaccuum_pump_3',
    //             'air_presure_supply_2',
    //             'box_4',
    //             'vaccuum_pump_4',
    //             'air_presure_3',
    //             'temperature_control_4',
    //             'water_reservoirs',
    //             'filter',
    //             'angle_and_filter_2',
    //             'stop_time',
    //             'run_time',
    //             'approval',
    //             'group',
    //             'status',
    //             'approved_by'
    //         ]);
    // }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getOverallStatusAttribute(): string
    {
        $toggleFields = [
            'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine', 'brush',
            'vacume_brush', 'cleaning_roller', 'ionizer', 'ipa_solvent', 'box', 'vaccuum_parameter',
            'box_2', 'vaccuum_parameter_2', 'abandonment', 'fire_posibilty', 'rail_and_transfer_unit',
            'fire_posibilty_2', 'cylinder_2', 'rail_and_magazine_pcb_2', 'cover_magazine_2',
            'angle_and_filter', 'lamp_indicator', 'box_3', 'box_4', 'water_reservoirs', 'filter',
            'angle_and_filter_2', 'expire_date', 'expire_date_2'
        ];

        foreach ($toggleFields as $field) {
            $value = $this->{$field};
            
            if ($value === null || $value === '' || !in_array($value, ['checked', 'na'])) {
                return 'danger';
            }
        }

        $numericRanges = [
            'air_presure' => [0.45, 0.54],
            'vacume_presure_unitech' => [0.45, 0.54],
            'vacume_presure_nix' => [0.60, 0.70],
            'conveyor_speed' => [null, 40],
            'temperature_control_1' => [23, 27],
            'humidity_control_1' => [35, 70],
            'clamp_presure_sp_60' => [0.20, 0.40],
            'clamp_presure_spg_2' => [0.20, 0.40],
            'squeege_sp_60' => [0.19, 0.21],
            'squeege_spg_2' => [0.11, 0.13],
            'cleaning_solvent' => [0.19, 0.21],
            'air_presure_meter' => [0.50, 0.55],
            'air_presure_meter_parmi' => [0.40, 0.50],
            'capability_index' => [1.33, null],
            'vaccuum_pump' => [-100, -87],
            'vaccuum_pump_2' => [-100, -87],
            'n2_presure' => [0.4, 0.5],
            'oxygent_density_sek' => [1200, 1800],
            'oxygent_density_special' => [500, 1000],
            'air_presure_2' => [0.40, 0.50],
            'temperature_chiller' => [17, 23],
            'temperature_control_3' => [290, 310],
            'air_presure_supply' => [0.49, 0.54],
            'vaccuum_pump_3' => [-100, -87],
            'air_presure_supply_2' => [0.49, 0.54],
            'vaccuum_pump_4' => [-100, -87],
            'air_presure_3' => [0.40, 0.50],
            'temperature_control_4' => [23, 27],
        ];

        foreach ($numericRanges as $field => $range) {
            $value = $this->{$field};
            
            if ($value === null || $value === '') {
                return 'danger';
            }
            
            if ($value === '-') {
                continue;
            }
            
            $floatValue = floatval($value);
            $min = $range[0];
            $max = $range[1];
            
            if ($min !== null && $floatValue < $min) {
                return 'danger';
            }
            
            if ($max !== null && $floatValue > $max) {
                return 'danger';
            }

        }


            if ($this->group === null || $this->group === '') {
                return 'danger';
            }

        return 'success';
    }

    public function getOverallStatusIconAttribute(): string
    {
        return $this->overall_status === 'success' ? 'heroicon-s-check-circle' : 'heroicon-s-x-circle';
    }

    public function getOverallStatusTextAttribute(): string
    {
        return $this->overall_status === 'success' 
            ? 'All parameters OK' 
            : 'Some parameters are invalid or not checked';
    }

    public function getShiftEnd(): Carbon
    {
        $created = Carbon::parse($this->created_at);
        $dayOfWeek = $created->dayOfWeek;

        if ($dayOfWeek === 6) {
            if ($created->between(
                $created->copy()->setTime(7, 0),
                $created->copy()->setTime(12, 15),
                false
            )) {
                return $created->copy()->setTime(12, 15);

            } elseif ($created->between(
                $created->copy()->setTime(12, 15),
                $created->copy()->setTime(17, 45),
                false
            )) {
                return $created->copy()->setTime(17, 45);

            } else {
                return $created->copy()->setTime(23, 0);
            }
        }

        if ($created->hour >= 7 && $created->hour < 15) {
            return $created->copy()->setTime(15, 0);

        } elseif ($created->hour >= 15 && $created->hour < 23) {
            return $created->copy()->setTime(23, 0);

        } else {
            return $created->copy()->addDay()->setTime(7, 0);
        }
    }
}
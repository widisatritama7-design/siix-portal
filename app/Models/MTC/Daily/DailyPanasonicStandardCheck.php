<?php

namespace App\Models\MTC\Daily;

use App\Models\MTC\Master\MasterLine;
use App\Models\MTC\Daily\DailyPanasonicStandardCheckHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPanasonicStandardCheck extends Model
{
    use HasFactory;

    protected $table = 'tb_mtc_daily_panasonic_standard_checks';

    protected $fillable = [
        'master_line_id',
        'body_cover_required',
        'lamp_alarm_change_model_required',
        'cylinder_required',
        'rail_and_magazine_pcb_required',
        'cover_magazine_required',
        'brush_required',
        'air_presure_required',
        'vacume_presure_unitech_required',
        'vacume_presure_nix_required',
        'vacume_brush_required',
        'cleaning_roller_required',
        'ionizer_required',
        'conveyor_speed_required',
        'ipa_solvent_required',
        'temperature_control_1_required',
        'humidity_control_1_required',
        'clamp_presure_sp_60_required',
        'clamp_presure_spg_2_required',
        'squeege_sp_60_required',
        'squeege_spg_2_required',
        'cleaning_solvent_required',
        'air_presure_meter_required',
        'air_presure_meter_parmi_required',
        'capability_index_required',
        'air_presure_supply_required',
        'vaccuum_pump_required',
        'box_required',
        'vaccuum_parameter_required',
        'expire_date_required',
        'air_presure_supply_2_required',
        'vaccuum_pump_2_required',
        'box_2_required',
        'vaccuum_parameter_2_required',
        'expire_date_2_required',
        'abandonment_required',
        'fire_posibilty_required',
        'flashlight_required',
        'rail_and_transfer_unit_required',
        'n2_presure_required',
        'oxygent_density_sek_required',
        'oxygent_density_special_required',
        'fire_posibilty_2_required',
        'air_presure_2_required',
        'cylinder_2_required',
        'rail_and_magazine_pcb_2_required',
        'cover_magazine_2_required',
        'angle_and_filter_required',
        'lamp_indicator_required',
        'temperature_chiller_required',
        'temperature_control_3_required',
        'box_3_required',
        'vaccuum_pump_3_required',
        'box_4_required',
        'vaccuum_pump_4_required',
        'air_presure_3_required',
        'temperature_control_4_required',
        'water_reservoirs_required',
        'filter_required',
        'angle_and_filter_2_required',
    ];

    protected $casts = [
        'body_cover_required' => 'boolean',
        'lamp_alarm_change_model_required' => 'boolean',
        'cylinder_required' => 'boolean',
        'rail_and_magazine_pcb_required' => 'boolean',
        'cover_magazine_required' => 'boolean',
        'brush_required' => 'boolean',
        'air_presure_required' => 'boolean',
        'vacume_presure_unitech_required' => 'boolean',
        'vacume_presure_nix_required' => 'boolean',
        'vacume_brush_required' => 'boolean',
        'cleaning_roller_required' => 'boolean',
        'ionizer_required' => 'boolean',
        'conveyor_speed_required' => 'boolean',
        'ipa_solvent_required' => 'boolean',
        'temperature_control_1_required' => 'boolean',
        'humidity_control_1_required' => 'boolean',
        'clamp_presure_sp_60_required' => 'boolean',
        'clamp_presure_spg_2_required' => 'boolean',
        'squeege_sp_60_required' => 'boolean',
        'squeege_spg_2_required' => 'boolean',
        'cleaning_solvent_required' => 'boolean',
        'air_presure_meter_required' => 'boolean',
        'air_presure_meter_parmi_required' => 'boolean',
        'capability_index_required' => 'boolean',
        'air_presure_supply_required' => 'boolean',
        'vaccuum_pump_required' => 'boolean',
        'box_required' => 'boolean',
        'vaccuum_parameter_required' => 'boolean',
        'expire_date_required' => 'boolean',
        'air_presure_supply_2_required' => 'boolean',
        'vaccuum_pump_2_required' => 'boolean',
        'box_2_required' => 'boolean',
        'vaccuum_parameter_2_required' => 'boolean',
        'expire_date_2_required' => 'boolean',
        'abandonment_required' => 'boolean',
        'fire_posibilty_required' => 'boolean',
        'flashlight_required' => 'boolean',
        'rail_and_transfer_unit_required' => 'boolean',
        'n2_presure_required' => 'boolean',
        'oxygent_density_sek_required' => 'boolean',
        'oxygent_density_special_required' => 'boolean',
        'fire_posibilty_2_required' => 'boolean',
        'air_presure_2_required' => 'boolean',
        'cylinder_2_required' => 'boolean',
        'rail_and_magazine_pcb_2_required' => 'boolean',
        'cover_magazine_2_required' => 'boolean',
        'angle_and_filter_required' => 'boolean',
        'lamp_indicator_required' => 'boolean',
        'temperature_chiller_required' => 'boolean',
        'temperature_control_3_required' => 'boolean',
        'box_3_required' => 'boolean',
        'vaccuum_pump_3_required' => 'boolean',
        'box_4_required' => 'boolean',
        'vaccuum_pump_4_required' => 'boolean',
        'air_presure_3_required' => 'boolean',
        'temperature_control_4_required' => 'boolean',
        'water_reservoirs_required' => 'boolean',
        'filter_required' => 'boolean',
        'angle_and_filter_2_required' => 'boolean',
    ];

    public function masterLine()
    {
        return $this->belongsTo(MasterLine::class, 'master_line_id');
    }


    public function histories()
    {
        return $this->hasMany(DailyPanasonicStandardCheckHistory::class, 'standard_check_id')
            ->orderBy('created_at', 'desc');
    }

    public static function getRequiredFields($masterLineId)
    {
        $standard = self::where('master_line_id', $masterLineId)->first();
        
        if (!$standard) {
            return self::getDefaultRequiredFields();
        }

        $required = [];
        $fillable = (new self)->getFillable();
        
        foreach ($fillable as $field) {
            if (str_ends_with($field, '_required') && $standard->{$field}) {
                $fieldName = str_replace('_required', '', $field);
                $required[] = $fieldName;
            }
        }

        return $required;
    }

    public static function getDefaultRequiredFields()
    {
        return [
            // STEP 1: GENERAL
            'body_cover',
            'lamp_alarm_change_model',
            
            // STEP 2: LOADER
            'cylinder',
            'rail_and_magazine_pcb',
            'cover_magazine',
            
            // STEP 3: PCB CLEANER
            'brush',
            'air_presure',
            'vacume_presure_unitech',
            'vacume_presure_nix',
            'vacume_brush',
            'cleaning_roller',
            'ionizer',
            'conveyor_speed',
            
            // STEP 4: PRINTING
            'ipa_solvent',
            'temperature_control_1',
            'humidity_control_1',
            'clamp_presure_sp_60',
            'clamp_presure_spg_2',
            'squeege_sp_60',
            'squeege_spg_2',
            'cleaning_solvent',
            'air_presure_meter',
            
            // STEP 5: SPI
            'air_presure_meter_parmi',
            'capability_index',
            
            // STEP 6: CHIP MOUNTER 1
            'air_presure_supply',
            'vaccuum_pump',
            'box',
            'vaccuum_parameter',
            'expire_date',
            
            // STEP 7: CHIP MOUNTER 2
            'air_presure_supply_2',
            'vaccuum_pump_2',
            'box_2',
            'vaccuum_parameter_2',
            'expire_date_2',
            
            // STEP 8: REFLOW
            'abandonment',
            'fire_posibilty',
            'flashlight',
            'rail_and_transfer_unit',
            'n2_presure',
            'oxygent_density_sek',
            'oxygent_density_special',
            'fire_posibilty_2',
            
            // STEP 9: AOI
            'air_presure_2',
            
            // STEP 10: UNLOADER
            'cylinder_2',
            'rail_and_magazine_pcb_2',
            'cover_magazine_2',
            
            // STEP 11: AOI TABLE
            'angle_and_filter',
            'lamp_indicator',
            
            // STEP 12: REFLOW 2
            'temperature_chiller',
            'temperature_control_3',
            
            // STEP 13: CHIP MOUNTER 3
            'box_3',
            'vaccuum_pump_3',
            
            // STEP 14: CHIP MOUNTER 4
            'box_4',
            'vaccuum_pump_4',
            
            // STEP 15: SPI 2
            'air_presure_3',
            
            // STEP 16: PRINTER
            'temperature_control_4',
            'water_reservoirs',
            
            // STEP 17: PCB CLEANER 2
            'filter',
            
            // STEP 18: IONIZER
            'angle_and_filter_2',
        ];
    }

        /**
     * Get step number for a field
     */
    public static function getStepForField($field)
    {
        $stepMapping = [
            // STEP 1: GENERAL
            'body_cover' => 1,
            'lamp_alarm_change_model' => 1,
            
            // STEP 2: LOADER
            'cylinder' => 2,
            'rail_and_magazine_pcb' => 2,
            'cover_magazine' => 2,
            
            // STEP 3: PCB CLEANER
            'brush' => 3,
            'air_presure' => 3,
            'vacume_presure_unitech' => 3,
            'vacume_presure_nix' => 3,
            'vacume_brush' => 3,
            'cleaning_roller' => 3,
            'ionizer' => 3,
            'conveyor_speed' => 3,
            
            // STEP 4: PRINTING
            'ipa_solvent' => 4,
            'temperature_control_1' => 4,
            'humidity_control_1' => 4,
            'clamp_presure_sp_60' => 4,
            'clamp_presure_spg_2' => 4,
            'squeege_sp_60' => 4,
            'squeege_spg_2' => 4,
            'cleaning_solvent' => 4,
            'air_presure_meter' => 4,
            
            // STEP 5: SPI
            'air_presure_meter_parmi' => 5,
            'capability_index' => 5,
            
            // STEP 6: CHIP MOUNTER 1
            'air_presure_supply' => 6,
            'vaccuum_pump' => 6,
            'box' => 6,
            'vaccuum_parameter' => 6,
            'expire_date' => 6,
            
            // STEP 7: CHIP MOUNTER 2
            'air_presure_supply_2' => 7,
            'vaccuum_pump_2' => 7,
            'box_2' => 7,
            'vaccuum_parameter_2' => 7,
            'expire_date_2' => 7,
            
            // STEP 8: REFLOW
            'abandonment' => 8,
            'fire_posibilty' => 8,
            'flashlight' => 8,
            'rail_and_transfer_unit' => 8,
            'n2_presure' => 8,
            'oxygent_density_sek' => 8,
            'oxygent_density_special' => 8,
            'fire_posibilty_2' => 8,
            
            // STEP 9: AOI
            'air_presure_2' => 9,
            
            // STEP 10: UNLOADER
            'cylinder_2' => 10,
            'rail_and_magazine_pcb_2' => 10,
            'cover_magazine_2' => 10,
            
            // STEP 11: AOI TABLE
            'angle_and_filter' => 11,
            'lamp_indicator' => 11,
            
            // STEP 12: REFLOW 2
            'temperature_chiller' => 12,
            'temperature_control_3' => 12,
            
            // STEP 13: CHIP MOUNTER 3
            'box_3' => 13,
            'vaccuum_pump_3' => 13,
            
            // STEP 14: CHIP MOUNTER 4
            'box_4' => 14,
            'vaccuum_pump_4' => 14,
            
            // STEP 15: SPI 2
            'air_presure_3' => 15,
            
            // STEP 16: PRINTER
            'temperature_control_4' => 16,
            'water_reservoirs' => 16,
            
            // STEP 17: PCB CLEANER 2
            'filter' => 17,
            
            // STEP 18: IONIZER
            'angle_and_filter_2' => 18,
        ];

        return $stepMapping[$field] ?? null;
    }

    /**
     * Get step name for a step number
     */
    public static function getStepName($step)
    {
        $stepNames = [
            1 => 'GENERAL',
            2 => 'LOADER',
            3 => 'PCB CLEANER',
            4 => 'PRINTING',
            5 => 'SPI',
            6 => 'CHIP MOUNTER 1',
            7 => 'CHIP MOUNTER 2',
            8 => 'REFLOW',
            9 => 'AOI',
            10 => 'UNLOADER',
            11 => 'AOI TABLE',
            12 => 'REFLOW 2',
            13 => 'CHIP MOUNTER 3',
            14 => 'CHIP MOUNTER 4',
            15 => 'SPI 2',
            16 => 'PRINTER',
            17 => 'PCB CLEANER 2',
            18 => 'IONIZER',
        ];

        return $stepNames[$step] ?? 'Unknown Step';
    }
}
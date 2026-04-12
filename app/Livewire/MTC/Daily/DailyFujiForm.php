<?php

namespace App\Livewire\MTC\Daily;

use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Master\MasterLine;
use Livewire\Component;

class DailyFujiForm extends Component
{
    public $master_line_id;
    public $masterLine;
    public $isEdit = false;
    public $dailyFujiId;
    
    // STEP 1: GENERAL
    public $body_cover;
    
    // STEP 2: LOADER
    public $cylinder;
    public $rail_and_magazine_pcb;
    public $cover_magazine;
    
    // STEP 3: PCB CLEANER
    public $brush;
    public $air_presure;
    public $vacume_presure_unitech;
    public $vacume_presure_nix;
    public $vacume_brush;
    public $cleaning_roller;
    public $ionizer;
    public $conveyor_speed;
    
    // STEP 4: PRINTING
    public $ipa_solvent;
    public $temperature_control_1;
    public $humidity_control_1;
    public $clamp_presure;
    public $squeege_upper;
    public $cleaning_solvent;
    public $air_presure_meter;
    
    // STEP 5: SPI
    public $air_presure_meter_parmi;
    public $capability_index;
    
    // STEP 6: CHIP MOUNTER 1
    public $air_presure_supply;
    public $vaccuum_pump_1;
    public $box_1;
    public $vaccuum_parameter_1;
    public $expire_date_1;
    
    // STEP 7: CHIP MOUNTER 2
    public $air_presure_supply_2;
    public $vaccuum_pump_2;
    public $box_2;
    public $vaccuum_parameter_2;
    public $expire_date_2;
    
    // STEP 8: REFLOW
    public $abandonment;
    public $fire_posibilty;
    public $rail_and_transfer_unit;
    public $n2_presure;
    public $oxygent_density_sek;
    public $oxygent_density_special;
    public $fire_posibilty_2;
    
    // STEP 9: AOI
    public $air_presure_2;
    
    // STEP 10: UNLOADER
    public $cylinder_2;
    public $rail_and_magazine_pcb_2;
    public $cover_magazine_2;
    
    // STEP 11: AOI TABLE
    public $angle_and_filter;
    public $lamp_indicator;
    
    // STEP 12: REFLOW 2
    public $temperature_chiller;
    public $temperature_control_3;
    
    // STEP 13: CHIP MOUNTER 3
    public $fan_unit_1;
    
    // STEP 14: CHIP MOUNTER 4
    public $fan_unit_2;
    
    // STEP 15: SPI 2
    public $air_presure_3;
    
    // STEP 16: PRINTER
    public $temperature_control_4;
    public $water_reservoirs;
    
    // STEP 17: PCB CLEANER 2
    public $filter;
    
    // STEP 18: IONIZER
    public $angle_and_filter_2;
    
    // TIME & STATUS
    public $stop_time;
    public $run_time;
    public $group;
    public $status = 'On Progress';
    public $approval = 'Pending';

    protected $rules = [
        'master_line_id' => 'required|exists:tb_mtc_master_lines,id',
        'group' => 'required|in:A,B,C',
        'run_time' => 'nullable',
        'stop_time' => 'nullable',
    ];

    protected $listeners = [
        'open-daily-fuji-form' => 'openForm'
    ];

    public function openForm($payload)
    {
        $masterLineId = $payload['masterLineId'] ?? null;
        $id = $payload['id'] ?? null;
        
        $this->master_line_id = $masterLineId;
        $this->masterLine = MasterLine::find($masterLineId);
        
        if ($id) {
            $this->isEdit = true;
            $this->dailyFujiId = $id;
            $this->loadData();
        } else {
            $this->resetForm();
        }
        
        $this->dispatch('open-modal', 'daily-fuji-form-modal');
    }

    public function resetForm()
    {
        $this->isEdit = false;
        $this->dailyFujiId = null;
        
        $properties = [
            'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine',
            'brush', 'air_presure', 'vacume_presure_unitech', 'vacume_presure_nix',
            'vacume_brush', 'cleaning_roller', 'ionizer', 'conveyor_speed',
            'ipa_solvent', 'temperature_control_1', 'humidity_control_1', 'clamp_presure',
            'squeege_upper', 'cleaning_solvent', 'air_presure_meter', 'air_presure_meter_parmi',
            'capability_index', 'air_presure_supply', 'vaccuum_pump_1', 'box_1',
            'vaccuum_parameter_1', 'expire_date_1', 'air_presure_supply_2', 'vaccuum_pump_2',
            'box_2', 'vaccuum_parameter_2', 'expire_date_2', 'abandonment', 'fire_posibilty',
            'rail_and_transfer_unit', 'n2_presure', 'oxygent_density_sek', 'oxygent_density_special',
            'fire_posibilty_2', 'air_presure_2', 'cylinder_2', 'rail_and_magazine_pcb_2',
            'cover_magazine_2', 'angle_and_filter', 'lamp_indicator', 'temperature_chiller',
            'temperature_control_3', 'fan_unit_1', 'fan_unit_2', 'air_presure_3',
            'temperature_control_4', 'water_reservoirs', 'filter', 'angle_and_filter_2',
            'stop_time', 'run_time', 'group'
        ];
        
        foreach ($properties as $property) {
            $this->$property = null;
        }
        $this->status = 'On Progress';
        $this->approval = 'Pending';
    }

    public function loadData()
    {
        $dailyFuji = DailyFuji::findOrFail($this->dailyFujiId);
        
        $fillableFields = [
            'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine',
            'brush', 'air_presure', 'vacume_presure_unitech', 'vacume_presure_nix',
            'vacume_brush', 'cleaning_roller', 'ionizer', 'conveyor_speed',
            'ipa_solvent', 'temperature_control_1', 'humidity_control_1', 'clamp_presure',
            'squeege_upper', 'cleaning_solvent', 'air_presure_meter', 'air_presure_meter_parmi',
            'capability_index', 'air_presure_supply', 'vaccuum_pump_1', 'box_1',
            'vaccuum_parameter_1', 'expire_date_1', 'air_presure_supply_2', 'vaccuum_pump_2',
            'box_2', 'vaccuum_parameter_2', 'expire_date_2', 'abandonment', 'fire_posibilty',
            'rail_and_transfer_unit', 'n2_presure', 'oxygent_density_sek', 'oxygent_density_special',
            'fire_posibilty_2', 'air_presure_2', 'cylinder_2', 'rail_and_magazine_pcb_2',
            'cover_magazine_2', 'angle_and_filter', 'lamp_indicator', 'temperature_chiller',
            'temperature_control_3', 'fan_unit_1', 'fan_unit_2', 'air_presure_3',
            'temperature_control_4', 'water_reservoirs', 'filter', 'angle_and_filter_2',
            'stop_time', 'run_time', 'group', 'status', 'approval'
        ];
        
        foreach ($fillableFields as $field) {
            if (property_exists($this, $field)) {
                $this->$field = $dailyFuji->$field;
            }
        }
        $this->master_line_id = $dailyFuji->master_line_id;
        $this->isEdit = true;
    }

    public function save()
    {
        $this->validate();
        
        $data = [];
        $fillableFields = [
            'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine',
            'brush', 'air_presure', 'vacume_presure_unitech', 'vacume_presure_nix',
            'vacume_brush', 'cleaning_roller', 'ionizer', 'conveyor_speed',
            'ipa_solvent', 'temperature_control_1', 'humidity_control_1', 'clamp_presure',
            'squeege_upper', 'cleaning_solvent', 'air_presure_meter', 'air_presure_meter_parmi',
            'capability_index', 'air_presure_supply', 'vaccuum_pump_1', 'box_1',
            'vaccuum_parameter_1', 'expire_date_1', 'air_presure_supply_2', 'vaccuum_pump_2',
            'box_2', 'vaccuum_parameter_2', 'expire_date_2', 'abandonment', 'fire_posibilty',
            'rail_and_transfer_unit', 'n2_presure', 'oxygent_density_sek', 'oxygent_density_special',
            'fire_posibilty_2', 'air_presure_2', 'cylinder_2', 'rail_and_magazine_pcb_2',
            'cover_magazine_2', 'angle_and_filter', 'lamp_indicator', 'temperature_chiller',
            'temperature_control_3', 'fan_unit_1', 'fan_unit_2', 'air_presure_3',
            'temperature_control_4', 'water_reservoirs', 'filter', 'angle_and_filter_2',
            'stop_time', 'run_time', 'group', 'status', 'approval'
        ];
        
        foreach ($fillableFields as $field) {
            if (property_exists($this, $field)) {
                $data[$field] = $this->$field;
            }
        }
        
        if ($this->isEdit) {
            $dailyFuji = DailyFuji::find($this->dailyFujiId);
            $dailyFuji->update($data);
            $message = 'Daily Fuji inspection updated successfully!';
        } else {
            $data['master_line_id'] = $this->master_line_id;
            $data['status'] = 'On Progress';
            $data['approval'] = 'Pending';
            DailyFuji::create($data);
            $message = 'Daily Fuji inspection created successfully!';
        }
        
        $this->dispatch('refreshDailyFujiTable');
        $this->dispatch('close-modal', 'daily-fuji-form-modal');
        $this->dispatch('notify', message: $message, type: 'success');
    }

    public function render()
    {
        return view('livewire.mtc.daily.daily-fuji-form');
    }
}
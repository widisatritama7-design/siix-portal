<?php

namespace App\Livewire\MTC\Daily;

use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Master\MasterLine;
use Livewire\Component;

class DailyFujiEdit extends Component
{
    public $masterLineId;
    public $dailyFujiId;
    public $masterLine;
    public $dailyFuji;
    public $overallStatus = 'danger';
    public $overallStatusText = 'Some parameters are invalid or not filled';
    
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
    public $status;
    public $approval;

    protected $rules = [
        'group' => 'required|in:A,B,C',
    ];

    protected $validationAttributes = [
        'group' => 'Group',
    ];

    // Field toggle yang perlu dicek
    protected $toggleFields = [
        'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine', 'brush',
        'vacume_brush', 'cleaning_roller', 'ionizer', 'ipa_solvent',
        'box_1', 'vaccuum_parameter_1', 'expire_date_1',
        'box_2', 'vaccuum_parameter_2', 'expire_date_2',
        'abandonment', 'fire_posibilty', 'rail_and_transfer_unit', 'fire_posibilty_2',
        'cylinder_2', 'rail_and_magazine_pcb_2', 'cover_magazine_2',
        'angle_and_filter', 'lamp_indicator', 'fan_unit_1', 'fan_unit_2',
        'water_reservoirs', 'filter', 'angle_and_filter_2'
    ];

    // Field numeric dengan range validasi
    protected $numericRanges = [
        'air_presure' => [0.45, 0.54],
        'vacume_presure_unitech' => [0.45, 0.54],
        'vacume_presure_nix' => [0.60, 0.70],
        'conveyor_speed' => [null, 40],
        'temperature_control_1' => [23, 27],
        'humidity_control_1' => [35, 70],
        'clamp_presure' => [0.20, 0.40],
        'squeege_upper' => [0.11, 0.13],
        'cleaning_solvent' => [0.19, 0.21],
        'air_presure_meter' => [0.50, 0.55],
        'air_presure_meter_parmi' => [0.40, 0.50],
        'capability_index' => [1.33, null],
        'air_presure_supply' => [0.49, 0.54],
        'vaccuum_pump_1' => [-100, -87],
        'air_presure_supply_2' => [0.49, 0.54],
        'vaccuum_pump_2' => [-100, -87],
        'n2_presure' => [0.4, 0.5],
        'oxygent_density_sek' => [1200, 1800],
        'oxygent_density_special' => [500, 1000],
        'air_presure_2' => [0.40, 0.50],
        'temperature_chiller' => [17, 23],
        'temperature_control_3' => [290, 310],
        'air_presure_3' => [0.40, 0.50],
        'temperature_control_4' => [23, 27],
    ];

    public function mount($masterLineId, $dailyFujiId)
    {
        $this->masterLineId = $masterLineId;
        $this->dailyFujiId = $dailyFujiId;
        
        $this->masterLine = MasterLine::with(['location', 'location.area'])->findOrFail($masterLineId);
        $this->dailyFuji = DailyFuji::findOrFail($dailyFujiId);
        
        if ($this->dailyFuji->master_line_id != $masterLineId) {
            abort(404, 'Daily Fuji record not found for this line.');
        }
        
        if (!auth()->user()->can('edit daily fuji')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadData();
        $this->judgement();
    }
    
    protected function loadData()
    {
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
                $this->$field = $this->dailyFuji->$field;
            }
        }
        
        // Format time fields untuk input HTML
        if ($this->stop_time && $this->stop_time instanceof \DateTime) {
            $this->stop_time = $this->stop_time->format('H:i');
        }
        if ($this->run_time && $this->run_time instanceof \DateTime) {
            $this->run_time = $this->run_time->format('H:i');
        }
    }

    public function updated($property)
    {
        $this->judgement();
    }

    public function judgement()
    {
        $isComplete = $this->checkOverallStatus();
        
        if ($isComplete) {
            $this->overallStatus = 'success';
            $this->overallStatusText = 'All parameters OK';
            $this->status = 'Checked';
        } else {
            $this->overallStatus = 'danger';
            $this->overallStatusText = 'Some parameters are invalid or not filled';
            // Jangan auto-update status ke On Progress karena bisa jadi memang sudah Checked sebelumnya
            // Biarkan status tetap seperti yang sudah ada
        }
    }

    protected function checkOverallStatus(): bool
    {
        foreach ($this->toggleFields as $field) {
            $value = $this->{$field};
            if ($value === null || $value === '' || !in_array($value, ['checked', 'na'])) {
                return false;
            }
        }

        foreach ($this->numericRanges as $field => $range) {
            $value = $this->{$field};
            
            if ($value === null || $value === '') {
                return false;
            }
            
            if ($value === '-') {
                continue;
            }
            
            $floatValue = floatval($value);
            $min = $range[0];
            $max = $range[1];
            
            if ($min !== null && $floatValue < $min) {
                return false;
            }
            
            if ($max !== null && $floatValue > $max) {
                return false;
            }
        }

        if ($this->group === null || $this->group === '') {
            return false;
        }

        return true;
    }

    public function validateNumericField($field, $value)
    {
        if (!isset($this->numericRanges[$field])) {
            return ['valid' => true, 'message' => ''];
        }
        
        if ($value === null || $value === '' || $value === '-') {
            return ['valid' => false, 'message' => 'Field ini harus diisi'];
        }
        
        $floatValue = floatval($value);
        $min = $this->numericRanges[$field][0];
        $max = $this->numericRanges[$field][1];
        
        if ($min !== null && $floatValue < $min) {
            return ['valid' => false, 'message' => "Nilai harus ≥ {$min}"];
        }
        
        if ($max !== null && $floatValue > $max) {
            return ['valid' => false, 'message' => "Nilai harus ≤ {$max}"];
        }
        
        return ['valid' => true, 'message' => ''];
    }

    public function getFieldColorClass($field, $value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return 'border-red-500 bg-red-50 dark:bg-red-950/20';
        }
        
        if (in_array($field, array_keys($this->numericRanges))) {
            $validation = $this->validateNumericField($field, $value);
            if (!$validation['valid']) {
                return 'border-red-500 bg-red-50 dark:bg-red-950/20';
            }
            return 'border-green-500 bg-green-50 dark:bg-green-950/20';
        }
        
        if (in_array($field, $this->toggleFields)) {
            if (in_array($value, ['checked', 'na'])) {
                return 'border-green-500 bg-green-50 dark:bg-green-950/20';
            }
            return 'border-red-500 bg-red-50 dark:bg-red-950/20';
        }
        
        return '';
    }

    public function update()
    {
        $this->validate();
        $this->judgement();
        
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
        
        $data['updated_by'] = auth()->id();
        
        $this->dailyFuji->update($data);
        
        session()->flash('message', 'Daily Fuji inspection updated successfully!');
        session()->flash('type', 'success');
        
        return redirect()->route('mtc.master-lines.show', $this->masterLineId);
    }

    public function cancel()
    {
        return redirect()->route('mtc.master-lines.show', $this->masterLineId);
    }

    public function render()
    {
        return view('livewire.mtc.daily.daily-fuji-edit');
    }
}
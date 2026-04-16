<?php

namespace App\Livewire\MTC\Daily\Panasonic;

use App\Models\MTC\Daily\DailyPanasonic;
use App\Models\MTC\Master\MasterLine;
use Carbon\Carbon;
use Livewire\Component;

class DailyPanasonicCreate extends Component
{
    public $masterLineId;
    public $masterLine;
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
    public $clamp_presure_sp_60;
    public $clamp_presure_spg_2;
    public $squeege_sp_60;
    public $squeege_spg_2;
    public $cleaning_solvent;
    public $air_presure_meter;
    
    // STEP 5: SPI
    public $air_presure_meter_parmi;
    public $capability_index;
    
    // STEP 6: CHIP MOUNTER 1
    public $air_presure_supply;
    public $vaccuum_pump;
    public $box;
    public $vaccuum_parameter;
    public $expire_date;
    
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
    public $box_3;
    public $vaccuum_pump_3;
    
    // STEP 14: CHIP MOUNTER 4
    public $box_4;
    public $vaccuum_pump_4;
    
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
        'group' => 'required|in:A,B,C',
    ];

    protected $validationAttributes = [
        'group' => 'Group',
    ];

    // Field toggle yang perlu dicek
    protected $toggleFields = [
        'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine', 'brush',
        'vacume_brush', 'cleaning_roller', 'ionizer', 'ipa_solvent',
        'box', 'vaccuum_parameter', 'expire_date',
        'box_2', 'vaccuum_parameter_2', 'expire_date_2',
        'abandonment', 'fire_posibilty', 'rail_and_transfer_unit', 'fire_posibilty_2',
        'cylinder_2', 'rail_and_magazine_pcb_2', 'cover_magazine_2',
        'angle_and_filter', 'lamp_indicator', 'box_3', 'box_4',
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
        'clamp_presure_sp_60' => [0.20, 0.40],
        'clamp_presure_spg_2' => [0.20, 0.40],
        'squeege_sp_60' => [0.19, 0.21],
        'squeege_spg_2' => [0.11, 0.13],
        'cleaning_solvent' => [0.19, 0.21],
        'air_presure_meter' => [0.50, 0.55],
        'air_presure_meter_parmi' => [0.40, 0.50],
        'capability_index' => [1.33, null],
        'air_presure_supply' => [0.49, 0.54],
        'vaccuum_pump' => [-100, -87],
        'air_presure_supply_2' => [0.49, 0.54],
        'vaccuum_pump_2' => [-100, -87],
        'n2_presure' => [0.4, 0.5],
        'oxygent_density_sek' => [1200, 1800],
        'oxygent_density_special' => [500, 1000],
        'air_presure_2' => [0.40, 0.50],
        'temperature_chiller' => [17, 23],
        'temperature_control_3' => [290, 310],
        'vaccuum_pump_3' => [-100, -87],
        'vaccuum_pump_4' => [-100, -87],
        'air_presure_3' => [0.40, 0.50],
        'temperature_control_4' => [23, 27],
    ];

    public function mount($masterLineId)
    {
        $this->masterLineId = $masterLineId;
        $this->masterLine = MasterLine::with(['location', 'location.area'])->findOrFail($masterLineId);
        
        if (!auth()->user()->can('create daily panasonic')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->status = 'On Progress';
        $this->approval = 'Pending';
    }

    /**
     * Auto-judgement: Update status berdasarkan semua field yang sudah diisi
     */
    public function updated($property)
    {
        $this->judgement();
    }

    /**
     * Lakukan judgement/validasi berdasarkan model DailyPanasonic
     */
    public function judgement()
    {
        $isComplete = $this->checkOverallStatus();
        $this->status = $isComplete ? 'Checked' : 'On Progress';
        
        if ($isComplete) {
            $this->overallStatus = 'success';
            $this->overallStatusText = 'All parameters OK';
        } else {
            $this->overallStatus = 'danger';
            $this->overallStatusText = 'Some parameters are invalid or not filled';
        }
    }

    /**
     * Cek semua field sesuai dengan rules di model DailyPanasonic
     */
    protected function checkOverallStatus(): bool
    {
        // Cek semua toggle fields
        foreach ($this->toggleFields as $field) {
            $value = $this->{$field};
            if ($value === null || $value === '' || !in_array($value, ['checked', 'na'])) {
                return false;
            }
        }

        // Cek numeric fields dengan range
        foreach ($this->numericRanges as $field => $range) {
            $value = $this->{$field};
            
            // PERBAIKAN: Nilai '-' dianggap valid (skip validasi)
            if ($value === null || $value === '' || $value === '-') {
                continue; // SKIP, tidak dianggap error
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

        // Cek group
        if ($this->group === null || $this->group === '') {
            return false;
        }

        return true;
    }

    /**
     * Cek validasi untuk field numeric tertentu
     */
    public function validateNumericField($field, $value)
    {
        if (!isset($this->numericRanges[$field])) {
            return ['valid' => true, 'message' => ''];
        }
        
        // PERBAIKAN: Nilai '-' dianggap valid
        if ($value === null || $value === '' || $value === '-') {
            return ['valid' => true, 'message' => '']; // BALIKAN VALID
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

    /**
     * Get color class untuk field berdasarkan validasi
     */
    public function getFieldColorClass($field, $value)
    {
        // PERBAIKAN: Nilai '-' dianggap valid (warna hijau)
        if ($value === null || $value === '') {
            return 'border-red-500 bg-red-50 dark:bg-red-950/20';
        }
        
        if ($value === '-') {
            return 'border-green-500 bg-green-50 dark:bg-green-950/20'; // WARNA HIJAU UNTUK '-'
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

    public function save()
    {
        $this->validate();
        
        // Pastikan judgement terakhir dijalankan
        $this->judgement();
        
        // Kumpulkan semua data
        $data = [];
        $fillableFields = [
            'body_cover', 'cylinder', 'rail_and_magazine_pcb', 'cover_magazine',
            'brush', 'air_presure', 'vacume_presure_unitech', 'vacume_presure_nix',
            'vacume_brush', 'cleaning_roller', 'ionizer', 'conveyor_speed',
            'ipa_solvent', 'temperature_control_1', 'humidity_control_1', 'clamp_presure_sp_60',
            'clamp_presure_spg_2', 'squeege_sp_60', 'squeege_spg_2', 'cleaning_solvent',
            'air_presure_meter', 'air_presure_meter_parmi', 'capability_index',
            'air_presure_supply', 'vaccuum_pump', 'box', 'vaccuum_parameter', 'expire_date',
            'air_presure_supply_2', 'vaccuum_pump_2', 'box_2', 'vaccuum_parameter_2', 'expire_date_2',
            'abandonment', 'fire_posibilty', 'rail_and_transfer_unit', 'n2_presure',
            'oxygent_density_sek', 'oxygent_density_special', 'fire_posibilty_2', 'air_presure_2',
            'cylinder_2', 'rail_and_magazine_pcb_2', 'cover_magazine_2', 'angle_and_filter',
            'lamp_indicator', 'temperature_chiller', 'temperature_control_3', 'box_3', 'vaccuum_pump_3',
            'box_4', 'vaccuum_pump_4', 'air_presure_3', 'temperature_control_4', 'water_reservoirs',
            'filter', 'angle_and_filter_2', 'stop_time', 'run_time', 'group', 'status', 'approval'
        ];
        
        foreach ($fillableFields as $field) {
            if (property_exists($this, $field)) {
                $data[$field] = $this->$field;
            }
        }
        
        $data['master_line_id'] = $this->masterLineId;
        
        DailyPanasonic::create($data);
        
        session()->flash('message', 'Daily Panasonic inspection created successfully!');
        session()->flash('type', 'success');
        
        return redirect()->route('mtc.master-lines.show', $this->masterLineId);
    }

    public function cancel()
    {
        return redirect()->route('mtc.master-lines.show', $this->masterLineId);
    }

    public function render()
    {
        return view('livewire.mtc.daily.panasonic.daily-panasonic-create');
    }
}
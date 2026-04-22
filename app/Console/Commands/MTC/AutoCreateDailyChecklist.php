<?php

namespace App\Console\Commands\MTC;

use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Daily\DailyPanasonic;
use App\Models\MTC\Master\MasterLine;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCreateDailyChecklist extends Command
{
    protected $signature = 'daily-checklist:create';
    protected $description = 'Automatically create daily checklist entries based on schedule';

    public function handle()
    {
        $this->info('Starting daily checklist creation...');
        
        try {
            $this->createChecklistEntries();
            $this->info('Daily checklist entries created successfully.');
            Log::info('Auto daily checklist created successfully at ' . Carbon::now());
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            Log::error('Failed to create auto daily checklist: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function createChecklistEntries()
    {
        // Ambil semua master line yang machine_type-nya 'fuji' atau 'panasonic' TANPA peduli status
        $masterLines = MasterLine::whereIn('machine_type', ['fuji', 'panasonic'])->get();

        $this->info("Found {$masterLines->count()} master lines with valid machine types");

        if ($masterLines->count() === 0) {
            $this->warn('No master lines found with valid machine types!');
            // Tampilkan data yang ada untuk debugging
            $allLines = MasterLine::all();
            $this->info("All master lines in database: " . $allLines->count());
            foreach ($allLines as $line) {
                $this->info(" - Line {$line->line_number}: machine_type='{$line->machine_type}', status='{$line->status}'");
            }
            return;
        }

        foreach ($masterLines as $masterLine) {
            $this->createEntriesForMasterLine($masterLine);
        }
    }

    private function createEntriesForMasterLine($masterLine)
    {
        $now = Carbon::now();

        $this->info("Processing master line: Line {$masterLine->line_number} (Type: {$masterLine->machine_type}, Status: {$masterLine->status})");

        // Buat entry Fuji jika machine_type adalah 'fuji'
        if ($masterLine->machine_type === 'fuji') {
            $this->createFujiEntry($masterLine, $now);
        }

        // Buat entry Panasonic jika machine_type adalah 'panasonic'
        if ($masterLine->machine_type === 'panasonic') {
            $this->createPanasonicEntry($masterLine, $now);
        }
    }

    private function createFujiEntry($masterLine, $now)
    {
        // Langsung buat entry tanpa cek hari ini
        DailyFuji::create([
            'master_line_id' => $masterLine->id,
            'status' => 'On Progress',
            'group' => null,
            'approval' => null,
            'run_time' => null,
            'stop_time' => null,
            'body_cover' => null,
            'cylinder' => null,
            'rail_and_magazine_pcb' => null,
            'cover_magazine' => null,
            'brush' => null,
            'vacume_brush' => null,
            'cleaning_roller' => null,
            'ionizer' => null,
            'filter' => null,
            'ipa_solvent' => null,
            'conveyor_speed' => null,
            'air_presure' => null,
            'vacume_presure_unitech' => null,
            'vacume_presure_nix' => null,
            'temperature_control_1' => null,
            'temperature_control_2' => null,
            'humidity_control_1' => null,
            'humidity_control_2' => null,
            'clamp_presure' => null,
            'squeege_upper' => null,
            'cleaning_solvent' => null,
            'air_presure_meter' => null,
            'air_presure_meter_parmi' => null,
            'air_presure_3' => null,
            'capability_index' => null,
            'air_presure_supply' => null,
            'fan_unit_1' => null,
            'fan_unit_2' => null,
            'air_presure_supply_2' => null,
            'vaccuum_pump' => null,
            'box' => null,
            'vaccuum_pump_2' => null,
            'box_2' => null,
            'vaccuum_parameter' => null,
            'vaccuum_parameter_2' => null,
            'expire_date' => null,
            'expire_date_2' => null,
            'abandonment' => null,
            'fire_posibilty' => null,
            'fire_posibilty_2' => null,
            'rail_and_transfer_unit' => null,
            'n2_presure' => null,
            'oxygent_density_sek' => null,
            'oxygent_density_special' => null,
            'temperature_chiller' => null,
            'temperature_control_3' => null,
            'air_presure_2' => null,
            'cylinder_2' => null,
            'rail_and_magazine_pcb_2' => null,
            'cover_magazine_2' => null,
            'angle_and_filter' => null,
            'lamp_indicator' => null,
            'temperature_control_4' => null,
            'water_reservoirs' => null,
            'angle_and_filter_2' => null,
            'created_at' => $now,
        ]);
        $this->info("Created Fuji entry for: Line {$masterLine->line_number}");
    }

    private function createPanasonicEntry($masterLine, $now)
    {
        // Langsung buat entry tanpa cek hari ini
        DailyPanasonic::create([
            'master_line_id' => $masterLine->id,
            'status' => 'On Progress',
            'group' => null,
            'approval' => null,
            'run_time' => null,
            'stop_time' => null,
            'body_cover' => null,
            'cylinder' => null,
            'rail_and_magazine_pcb' => null,
            'cover_magazine' => null,
            'brush' => null,
            'air_presure' => null,
            'vacume_presure_unitech' => null,
            'vacume_presure_nix' => null,
            'vacume_brush' => null,
            'cleaning_roller' => null,
            'ionizer' => null,
            'conveyor_speed' => null,
            'ipa_solvent' => null,
            'temperature_control_1' => null,
            'temperature_control_2' => null,
            'humidity_control_1' => null,
            'humidity_control_2' => null,
            'clamp_presure_sp_60' => null,
            'clamp_presure_spg_2' => null,
            'squeege_sp_60' => null,
            'squeege_spg_2' => null,
            'cleaning_solvent' => null,
            'air_presure_meter' => null,
            'air_presure_meter_parmi' => null,
            'capability_index' => null,
            'box' => null,
            'vaccuum_parameter' => null,
            'expire_date' => null,
            'vaccuum_pump' => null,
            'box_2' => null,
            'vaccuum_parameter_2' => null,
            'expire_date_2' => null,
            'vaccuum_pump_2' => null,
            'abandonment' => null,
            'fire_posibilty' => null,
            'rail_and_transfer_unit' => null,
            'n2_presure' => null,
            'oxygent_density_sek' => null,
            'oxygent_density_special' => null,
            'fire_posibilty_2' => null,
            'air_presure_2' => null,
            'cylinder_2' => null,
            'rail_and_magazine_pcb_2' => null,
            'cover_magazine_2' => null,
            'angle_and_filter' => null,
            'lamp_indicator' => null,
            'temperature_chiller' => null,
            'temperature_control_3' => null,
            'air_presure_supply' => null,
            'box_3' => null,
            'vaccuum_pump_3' => null,
            'air_presure_supply_2' => null,
            'box_4' => null,
            'vaccuum_pump_4' => null,
            'air_presure_3' => null,
            'temperature_control_4' => null,
            'water_reservoirs' => null,
            'filter' => null,
            'angle_and_filter_2' => null,
            'created_at' => $now,
        ]);
        $this->info("Created Panasonic entry for: Line {$masterLine->line_number}");
    }
}
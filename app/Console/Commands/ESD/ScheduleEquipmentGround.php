<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\EG\EquipmentGroundDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleEquipmentGround extends Command
{
    protected $signature = 'equipment:duplicate-today';
    protected $description = 'Duplicate EquipmentGroundDetail if next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = EquipmentGroundDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data dengan next_date = {$today}.");
            return;
        }

        $count = 0;

        foreach ($records as $record) {
            $alreadyDuplicated = EquipmentGroundDetail::where('equipment_ground_id', $record->equipment_ground_id)
                ->whereDate('created_at', $today)
                ->where('remarks', 'Schedule On')
                ->exists();

            if ($alreadyDuplicated) {
                continue; // Lewati jika sudah diduplikasi hari ini
            }

            EquipmentGroundDetail::create([
                'equipment_ground_id'     => $record->equipment_ground_id,
                'measure_results_ohm'     => null,
                'judgement_ohm'           => null,
                'measure_results_volts'   => null,
                'judgement_volts'         => null,
                'remarks'                 => 'Schedule On',
                'next_date'               => Carbon::today()->addMonth(),
                'created_by'              => 504,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            $count++;
        }

        $this->info("Berhasil menduplikasi {$count} data untuk tanggal {$today}.");
    }
}

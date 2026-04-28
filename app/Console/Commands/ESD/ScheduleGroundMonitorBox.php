<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\GB\GroundMonitorBoxDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleGroundMonitorBox extends Command
{
    protected $signature = 'groundmonitorbox:duplicate-today';
    protected $description = 'Duplicate GroundMonitorBoxDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = GroundMonitorBoxDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Ground Monitor Box dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            GroundMonitorBoxDetail::create([
                'ground_monitor_box_id' => $record->ground_monitor_box_id,
                'remarks'               => 'Schedule On',
                'next_date'             => Carbon::parse($record->next_date)->addYear(), // tahun depan
                'created_by'            => 504,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data Ground Monitor Box untuk tanggal {$today}.");
    }
}

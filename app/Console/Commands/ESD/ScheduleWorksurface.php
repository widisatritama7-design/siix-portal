<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Worksurface\WorksurfaceDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleWorksurface extends Command
{
    protected $signature = 'worksurface:duplicate-today';
    protected $description = 'Duplicate WorksurfaceDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = WorksurfaceDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data WorksurfaceDetail dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            WorksurfaceDetail::create([
                'worksurface_id'    => $record->worksurface_id,
                'area'             => $record->area,
                'location'         => $record->location,
                'item'             => $record->item,
                'remarks'          => 'Schedule On',
                'next_date'        => Carbon::parse($record->next_date)->addYear(),
                'created_by'       => 504,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data WorksurfaceDetail untuk tanggal {$today}.");
    }
}

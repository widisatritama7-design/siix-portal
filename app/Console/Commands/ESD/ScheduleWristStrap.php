<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\WS\WristStrap;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleWristStrap extends Command
{
    protected $signature = 'wriststrap:duplicate-today';
    protected $description = 'Duplicate WristStrap records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = WristStrap::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data WristStrap dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            WristStrap::create([
                'register_no'       => $record->register_no,
                'remarks'           => 'Schedule On',
                'next_date'         => Carbon::parse($record->next_date)->addMonth(),
                'created_by'        => 504,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data WristStrap untuk tanggal {$today}.");
    }
}

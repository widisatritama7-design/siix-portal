<?php

namespace App\Console\Commands;

use App\Models\ESD\Jig\JigDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleJig extends Command
{
    protected $signature = 'jig:duplicate-today';
    protected $description = 'Duplicate JigDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = JigDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Jig dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            JigDetail::create([
                'jigs_id'          => $record->jigs_id,
                'location'         => $record->location,
                'remarks'          => 'Schedule On',
                'next_date'        => Carbon::parse($record->next_date)->addYear(), // tahun depan
                'created_by'       => 504,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data Jig untuk tanggal {$today}.");
    }
}

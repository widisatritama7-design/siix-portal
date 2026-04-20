<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Flooring\FlooringDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleFlooring extends Command
{
    protected $signature = 'flooring:duplicate-today';
    protected $description = 'Duplicate Flooring if next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = FlooringDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Flooring dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            FlooringDetail::create([
                'flooring_id'      => $record->flooring_id,
                'area'             => $record->area,
                'location'         => $record->location,
                'b1'               => null,
                'b1_scientific'    => null,
                'judgement'        => null,
                'remarks'          => 'Schedule On',
                'next_date'        => Carbon::parse($record->next_date)->addYear(),
                'created_by'       => 504,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data Flooring untuk tanggal {$today}.");
    }
}

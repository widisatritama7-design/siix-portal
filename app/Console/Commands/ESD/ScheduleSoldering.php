<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Soldering\SolderingDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleSoldering extends Command
{
    protected $signature = 'soldering:duplicate-today';
    protected $description = 'Duplicate SolderingDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = SolderingDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data SolderingDetail dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            SolderingDetail::create([
                'soldering_id'       => $record->soldering_id,
                'area'               => $record->area,
                'location'           => $record->location,
                'remarks'            => 'Schedule On',
                'problem'            => null,
                'action'             => null,
                'result'             => null,
                'next_date'          => Carbon::parse($record->next_date)->addYear(),
                'spec'               => $record->spec,
                'line'               => $record->line,
                'running_customer'   => $record->running_customer,
                'shift'              => $record->shift,
                'running_status'     => $record->running_status,
                'created_by'         => 504,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data SolderingDetail untuk tanggal {$today}.");
    }
}

<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Packaging\PackagingDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SchedulePackaging extends Command
{
    protected $signature = 'packaging:duplicate-today';
    protected $description = 'Duplicate PackagingDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = PackagingDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Packaging dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            PackagingDetail::create([
                'packaging_id'    => $record->packaging_id,
                'remarks'         => 'Schedule On',
                'next_date'       => Carbon::parse($record->next_date)->addYear(), // bulan depan
                'created_by'      => 504,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data Packaging untuk tanggal {$today}.");
    }
}

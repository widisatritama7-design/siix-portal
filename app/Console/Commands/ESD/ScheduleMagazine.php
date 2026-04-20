<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Magazine\MagazineDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleMagazine extends Command
{
    protected $signature = 'magazine:duplicate-today';
    protected $description = 'Duplicate MagazineDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = MagazineDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Magazine dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            MagazineDetail::create([
                'magazines_id'     => $record->magazines_id,
                'remarks'          => 'Schedule On',
                'next_date'        => Carbon::parse($record->next_date)->addYear(), // bulan depan
                'created_by'       => 504,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data Magazine untuk tanggal {$today}.");
    }
}

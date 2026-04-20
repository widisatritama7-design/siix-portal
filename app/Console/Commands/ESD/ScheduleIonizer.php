<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Ionizer\IonizerDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleIonizer extends Command
{
    protected $signature = 'ionizer:duplicate-today';
    protected $description = 'Duplicate IonizerDetail records where next_date is today';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = IonizerDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Ionizer dengan next_date = {$today}.");
            return;
        }

        $count = 0;

        foreach ($records as $record) {
            $alreadyDuplicated = IonizerDetail::where('ionizer_id', $record->ionizer_id)
                ->whereDate('created_at', $today)
                ->where('remarks', 'Schedule On')
                ->exists();

            if ($alreadyDuplicated) {
                continue; // Lewati jika sudah diduplikasi hari ini
            }

            IonizerDetail::create([
                'ionizer_id'     => $record->ionizer_id,
                'area'           => $record->area,
                'location'       => $record->location,
                'remarks'        => 'Schedule On',
                'next_date'      => Carbon::parse($record->next_date)->addMonth(), // bulan depan
                'created_by'     => 504,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            $count++;
        }

        $this->info("Berhasil menduplikasi {$count} data Ionizer untuk tanggal {$today}.");
    }
}

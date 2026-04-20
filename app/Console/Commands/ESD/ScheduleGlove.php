<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Glove\GloveDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleGlove extends Command
{
    protected $signature = 'glovedetail:duplicate-today';
    protected $description = 'Duplicate GloveDetail records where next_date is today, and set new next_date automatically excluding weekends.';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $records = GloveDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data GloveDetail dengan next_date = {$today}.");
            return;
        }

        foreach ($records as $record) {
            // Tentukan interval berdasarkan delivery
            $intervalDays = match ($record->delivery) {
                '2x/week'   => 3,
                '2x/month'  => 14,
                '1x/month'  => 30,
                default     => 7,
            };

            // Hitung next_date
            $nextDate = now()->addDays($intervalDays);

            // Jika next_date jatuh Sabtu (6) atau Minggu (0), geser ke Senin
            if ($nextDate->isSaturday()) {
                $nextDate->addDays(2);
            } elseif ($nextDate->isSunday()) {
                $nextDate->addDay();
            }

            GloveDetail::create([
                'glove_id'      => $record->glove_id,
                'description'   => $record->description,
                'delivery'      => $record->delivery,
                'remarks'       => 'Schedule On',
                'created_at'    => now(),
                'updated_at'    => now(),
                'next_date'     => $nextDate,
                'created_by'    => 504,
            ]);
        }

        $this->info("Berhasil menduplikasi {$records->count()} data GloveDetail untuk tanggal {$today}.");
    }
}

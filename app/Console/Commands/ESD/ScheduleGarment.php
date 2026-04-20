<?php

namespace App\Console\Commands\ESD;

use App\Models\ESD\Garment\GarmentDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleGarment extends Command
{
    protected $signature = 'garment:duplicate-today';
    protected $description = 'Duplicate GarmentDetail records where next_date is today, one per NIK only if not already created today';

    public function handle()
    {
        $today = Carbon::today();
        $todayStr = $today->toDateString();

        // Ambil semua record next_date = hari ini
        $records = GarmentDetail::whereDate('next_date', $today)->get();

        if ($records->isEmpty()) {
            $this->info("Tidak ada data Garment dengan next_date = {$todayStr}.");
            return;
        }

        // Kelompokkan berdasarkan NIK, ambil yang pertama untuk setiap NIK
        $uniqueRecords = $records->unique('nik');

        $count = 0;

        foreach ($uniqueRecords as $record) {
            // Cek apakah record dengan nik ini sudah ada yang dibuat hari ini
            $alreadyExists = GarmentDetail::where('nik', $record->nik)
                ->whereDate('created_at', $today)
                ->exists();

            if ($alreadyExists) {
                $this->info("Lewati NIK {$record->nik}, sudah ada hari ini.");
                continue;
            }

            GarmentDetail::create([
                'nik'               => $record->nik,
                'name'              => $record->name,
                'remarks'           => 'Schedule On',
                'next_date'         => Carbon::parse($record->next_date)->addYear(),
                'created_by'        => 504,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            $count++;
        }

        if ($count > 0) {
            $this->info("Berhasil menduplikasi {$count} data Garment unik untuk tanggal {$todayStr}.");
        } else {
            $this->info("Semua data Garment sudah dibuat hari ini, tidak ada yang diduplikasi.");
        }
    }
}
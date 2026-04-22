<?php

namespace App\Console\Commands\MTC;

use App\Mail\MTC\DailyCheckReportMail;
use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Daily\DailyPanasonic;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckAndUpdateDailyChecklist extends Command
{
    protected $signature = 'daily-checklist:check-update';
    protected $description = 'Check and update On Progress status to Delay, then send email report';

    public function handle()
    {
        $now = Carbon::now();
        $currentDay = $now->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
        $currentTime = $now->format('H:i');
        
        $this->info("Checking for delayed entries for {$this->getDayName($currentDay)} at {$currentTime}");

        // Jadwal check untuk Senin-Jumat
        $weekdaySchedules = ['09:00', '17:00', '01:00'];
        
        // Jadwal check untuk Sabtu - sesuai permintaan
        $saturdaySchedules = ['09:00', '14:30', '19:45'];

        if ($this->shouldCheckForDelay($currentDay, $currentTime, $weekdaySchedules, $saturdaySchedules)) {
            $this->updateDelayedEntries();
            
            // Tunggu 5 menit sebelum kirim email
            $this->info("Waiting 5 minutes before sending email...");
            sleep(300);
            
            $this->sendDelayReport();
            $this->info('Delay check and report completed successfully.');
        } else {
            $this->info('No schedule match found for delay check.');
        }

        return Command::SUCCESS;
    }

    private function shouldCheckForDelay($currentDay, $currentTime, $weekdaySchedules, $saturdaySchedules)
    {
        // Skip Minggu (0)
        if ($currentDay === 0) {
            return false;
        }
        
        // Senin-Jumat (1-5)
        if ($currentDay >= 1 && $currentDay <= 5) {
            return in_array($currentTime, $weekdaySchedules);
        }
        
        // Sabtu (6)
        if ($currentDay === 6) {
            return in_array($currentTime, $saturdaySchedules);
        }
        
        return false;
    }

    private function updateDelayedEntries()
    {
        try {
            $now = Carbon::now();
            $today = $now->format('Y-m-d');
            
            $this->info("Checking for entries still On Progress...");

            // Update DailyFuji entries yang masih On Progress
            $fujiDelayed = DailyFuji::where('status', 'On Progress')
                ->whereDate('created_at', $today)
                ->update(['status' => 'Delay']);

            // Update DailyPanasonic entries yang masih On Progress
            $panasonicDelayed = DailyPanasonic::where('status', 'On Progress')
                ->whereDate('created_at', $today)
                ->update(['status' => 'Delay']);

            $this->info("Updated {$fujiDelayed} Fuji entries and {$panasonicDelayed} Panasonic entries to Delay status");

            Log::info("Auto delay update: {$fujiDelayed} Fuji, {$panasonicDelayed} Panasonic updated at " . $now);
            
        } catch (\Exception $e) {
            Log::error('Failed to update delayed entries: ' . $e->getMessage());
            $this->error('Error updating delayed entries: ' . $e->getMessage());
        }
    }

    private function sendDelayReport()
    {
        try {
            $now = Carbon::now();
            $today = $now->format('Y-m-d');

            $this->info("Generating daily report for {$today}...");

            // Ambil semua data dari Fuji dan Panasonic untuk hari ini
            $fujiData = DailyFuji::with('masterLine.location')
                ->whereDate('created_at', $today)
                ->orderBy('id', 'asc')
                ->get();

            $panasonicData = DailyPanasonic::with('masterLine.location')
                ->whereDate('created_at', $today)
                ->orderBy('id', 'asc')
                ->get();

            $reportData = [];

            // Gabungkan Fuji
            foreach ($fujiData as $fuji) {
                $reportData[] = [
                    'line_number' => $fuji->masterLine->line_number ?? 'Unknown Line',
                    'location_name' => optional($fuji->masterLine->location)->location_name ?? 'Unknown Location',
                    'machine_type' => 'Fuji',
                    'status' => $fuji->status,
                    'created_at' => $fuji->created_at->format('Y-m-d H:i:s'),
                ];
            }

            // Gabungkan Panasonic
            foreach ($panasonicData as $panasonic) {
                $reportData[] = [
                    'line_number' => $panasonic->masterLine->line_number ?? 'Unknown Line',
                    'location_name' => optional($panasonic->masterLine->location)->location_name ?? 'Unknown Location',
                    'machine_type' => 'Panasonic',
                    'status' => $panasonic->status,
                    'created_at' => $panasonic->created_at->format('Y-m-d H:i:s'),
                ];
            }

            // Sortir berdasarkan line_number
            usort($reportData, function ($a, $b) {
                return (int)$a['line_number'] <=> (int)$b['line_number'];
            });

            // Hilangkan duplikat line_number (ambil 1 data terbaru per line)
            $reportData = collect($reportData)
                ->unique('line_number')
                ->values()
                ->all();

            if (empty($reportData)) {
                $this->info("No entries found for today's report.");
                return;
            }

            // Tentukan shift berdasarkan waktu
            $shift = $this->getCurrentShift($now);

            // Kirim email ke penerima utama dan cc
            Mail::to(['SEK.Production01-SMT@siix-global.com', 'SEK.Production01@siix-global.com'])
                ->cc(['dewi.simawati@siix-global.com', 'bonizar@siix-global.com', 'sek.esd@siix-global.com'])
                ->send(new DailyCheckReportMail($shift, $now, $reportData));

            $this->info("Daily report email sent successfully for shift {$shift}");
            Log::info("Daily report email sent for shift {$shift} at " . $now);

        } catch (\Exception $e) {
            Log::error('Failed to send daily report: ' . $e->getMessage());
            $this->error('Error sending daily report: ' . $e->getMessage());
        }
    }

    private function getCurrentShift(Carbon $time)
    {
        $hour = $time->hour;
        $currentDay = $time->dayOfWeek;

        // Sabtu schedule
        if ($currentDay === 6) { // Saturday
            if ($hour >= 7 && $hour < 12) return 1;
            if ($hour >= 12 && $hour < 17) return 2;
            return 3;
        }

        // Weekday schedule
        if ($hour >= 7 && $hour < 15) return 1;
        if ($hour >= 15 && $hour < 23) return 2;
        return 3;
    }

    private function getDayName($dayOfWeek)
    {
        $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return $dayNames[$dayOfWeek];
    }
}
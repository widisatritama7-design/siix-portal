<?php

namespace App\Console\Commands\PROD;

use App\Mail\PROD\ExpiredMasterSampleNotification;
use App\Models\PROD\MS\MasterSample;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendExpiredMasterSampleNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master-sample:send-expired-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email notifikasi master sample yang expired bulan ini (setiap Senin 08:00)';

    /**
     * Daftar penerima email.
     */
    protected array $recipients = [
        'wahyu.hadian@siix-global.com',
        'sek.production01-qc@siix-global.com',
        'sek.esd@siix-global.com',
        'retno.pujiastuti@siix-global.com',
        'bonizar@siix-global.com',
    ];

    public function handle(): int
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->startOfDay();
        $endOfMonth   = $now->copy()->endOfMonth()->endOfDay();

        $this->info("Mengambil data master sample expired periode: "
            . $startOfMonth->format('d M Y') . ' s/d ' . $endOfMonth->format('d M Y'));

        // Ambil sample ACTIVE yang detail expired-nya berada di bulan ini
        $samples = MasterSample::query()
            ->with(['details' => function ($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('expired_date', [$startOfMonth, $endOfMonth])
                  ->orderBy('expired_date');
            }, 'rack'])
            ->where('status', 'ACTIVE')
            ->whereHas('details', function ($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('expired_date', [$startOfMonth, $endOfMonth]);
            })
            ->get()
            ->map(function (MasterSample $sample) {
                // Ambil detail paling cepat expired di bulan ini
                $detail = $sample->details
                    ->sortBy('expired_date')
                    ->first();

                return (object) [
                    'model_name'    => $sample->model_name,
                    'customer'      => $sample->customer,
                    'name_or_mc'    => $sample->name_or_mc,
                    'status'        => $sample->status,
                    'expired_date'  => $detail?->expired_date,
                    'rack_label'    => $sample->rack
                        ? "Type: {$sample->rack->type_rack} - Col: {$sample->rack->column_rack} - Sheet: {$sample->rack->sheet_rack}"
                        : '-',
                ];
            })
            ->filter(fn ($item) => !empty($item->expired_date))
            ->sortBy('expired_date')
            ->values();

        $periodLabel = $now->copy()->translatedFormat('F Y');

        if ($samples->isEmpty()) {
            $this->info('Tidak ada master sample expired bulan ini. Email tetap dikirim sebagai konfirmasi.');

            // Opsional: tetap kirim email "kosong" sebagai konfirmasi.
            // Jika tidak ingin kirim saat kosong, uncomment baris return di bawah.
            // return self::SUCCESS;
        }

        try {
            foreach ($this->recipients as $email) {
                Mail::to($email)
                    ->send(new ExpiredMasterSampleNotification($samples, $periodLabel));

                $this->info("Email terkirim ke: {$email}");
            }
        } catch (\Throwable $e) {
            $this->error('Gagal mengirim email: ' . $e->getMessage());
            report($e);
            return self::FAILURE;
        }

        $this->info('Selesai. Total sample expired bulan ini: ' . $samples->count());

        return self::SUCCESS;
    }
}
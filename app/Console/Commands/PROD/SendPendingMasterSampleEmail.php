<?php

namespace App\Console\Commands\PROD;

use App\Mail\PROD\PendingMasterSampleMail;
use App\Models\PROD\MS\DetailMasterSample;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPendingMasterSampleEmail extends Command
{
    protected $signature = 'email:pending-master-sample';
    protected $description = 'Kirim email summary Master Sample yang belum di-check/approve/knowladge per user';

    public function handle()
    {
        $this->info('Mulai mengirim email pending Master Sample...');

        // ====================
        // CHECK
        // ====================
        $checkUsers = User::permission('check master sample')->get();
        $this->info("User Check ditemukan: {$checkUsers->count()}");
        foreach ($checkUsers as $user) {
            if (empty($user->emails)) {
                $this->warn("User {$user->name} ({$user->id}) tidak punya email. Lewat.");
                continue;
            }

            $total = DetailMasterSample::where('checked_by', $user->id)
                ->whereNull('check_date')
                ->count();

            if ($total > 0) {
                try {
                    Mail::to($user->emails)
                        ->send(new PendingMasterSampleMail($user, 'Check', $total));
                    $this->info("Check email terkirim ke {$user->emails} ({$total})");
                } catch (\Throwable $e) {
                    $this->error("Gagal kirim Check email ke {$user->emails}: " . $e->getMessage());
                }
            }
        }

        // ====================
        // APPROVE
        // ====================
        $approveUsers = User::permission('approve master sample')->get();
        $this->info("User Approve ditemukan: {$approveUsers->count()}");
        foreach ($approveUsers as $user) {
            if (empty($user->emails)) {
                $this->warn("User {$user->name} ({$user->id}) tidak punya email. Lewat.");
                continue;
            }

            $total = DetailMasterSample::where('approved_by', $user->id)
                ->whereNull('approve_date')
                ->count();

            if ($total > 0) {
                try {
                    Mail::to($user->emails)
                        ->send(new PendingMasterSampleMail($user, 'Approve', $total));
                    $this->info("Approve email terkirim ke {$user->emails} ({$total})");
                } catch (\Throwable $e) {
                    $this->error("Gagal kirim Approve email ke {$user->emails}: " . $e->getMessage());
                }
            }
        }

        // ====================
        // KNOWLADGE
        // ====================
        // Ambil user via role & permission (lebih aman)
        $knowladgeUsers = User::whereHas('roles.permissions', function ($q) {
            $q->where('name', 'knowladge master sample');
        })->get();

        $this->info("User Knowladge ditemukan: {$knowladgeUsers->count()}");
        foreach ($knowladgeUsers as $user) {
            if (empty($user->emails)) {
                $this->warn("User {$user->name} ({$user->id}) tidak punya email. Lewat.");
                continue;
            }

            $total = DetailMasterSample::where('knowladge_by', $user->id)
                ->whereNull('knowladge_date')
                ->count();

            if ($total > 0) {
                try {
                    Mail::to($user->emails)
                        ->send(new PendingMasterSampleMail($user, 'Knowladge', $total));
                    $this->info("Knowladge email terkirim ke {$user->emails} ({$total})");
                } catch (\Throwable $e) {
                    $this->error("Gagal kirim Knowladge email ke {$user->emails}: " . $e->getMessage());
                }
            }
        }

        $this->info('Selesai mengirim semua email.');
    }
}

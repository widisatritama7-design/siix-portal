<?php

namespace App\Console\Commands\DCC;

use App\Models\DCC\Submission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendOverdueSubmissionAlert extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'submission:send-pending-alert';

    /**
     * Deskripsi command
     */
    protected $description = 'Send email alert for all submissions that are waiting to be distributed';

    /**
     * Handle command
     */
    // public function handle()
    // {
    //     // Ambil SEMUA submission yang masih Waiting Distribute
    //     $submissions = Submission::where('status', 'Received')
    //         ->where('status_distribute', 'Waiting Distribute')
    //         ->orderBy('due_date', 'asc')
    //         ->get();

    //     if ($submissions->count() > 0) {

    //         $to = 'SEK.DCC@siix-global.com';
    //         $cc = 'wuwuh.sp@siix-global.com';

    //         Mail::send(
    //             'emails.DCC.overdue-submission-alert',
    //             ['submissions' => $submissions],
    //             function ($message) use ($to, $cc) {
    //                 $message->to($to)
    //                     ->cc($cc)
    //                     ->subject('📌 PENDING SUBMISSION REPORT - ' . now()->format('d M Y'));
    //             }
    //         );

    //         $this->info(
    //             'Pending submission alert sent. Total: ' . $submissions->count()
    //         );
    //     } else {
    //         $this->info('No pending submissions found.');
    //     }

    //     return Command::SUCCESS;
    // }

    public function handle()
    {
        // Ambil SEMUA submission yang masih Waiting Distribute
        $submissions = Submission::where('status', 'Received')
            ->where('status_distribute', 'Waiting Distribute')
            ->orderBy('due_date', 'asc')
            ->get();

        if ($submissions->count() > 0) {

            $to = 'sek.esd@siix-global.com';
            $cc = 'widifajarsatritama@gmail.com';

            Mail::send(
                'emails.DCC.overdue-submission-alert',
                ['submissions' => $submissions],
                function ($message) use ($to, $cc) {
                    $message->to($to)
                        ->cc($cc)
                        ->subject('📌 PENDING SUBMISSION REPORT - ' . now()->format('d M Y'));
                }
            );

            $this->info(
                'Pending submission alert sent. Total: ' . $submissions->count()
            );
        } else {
            $this->info('No pending submissions found.');
        }

        return Command::SUCCESS;
    }
}

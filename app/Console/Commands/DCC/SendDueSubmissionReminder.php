<?php

namespace App\Console\Commands\DCC;

use App\Models\DCC\Submission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDueSubmissionReminder extends Command
{
    protected $signature = 'submission:send-waiting-received-reminder';

    protected $description = 'Send email reminder for all submissions with status Waiting Received';

    // public function handle()
    // {
    //     // Ambil SEMUA submission dengan status Waiting Received
    //     $submissions = Submission::where('status', 'Waiting Received')
    //         ->orderBy('due_date', 'asc')
    //         ->get();

    //     if ($submissions->count() > 0) {

    //         $to = 'SEK.DCC@siix-global.com';
    //         $cc = 'wuwuh.sp@siix-global.com';

    //         Mail::send(
    //             'emails.DCC.due-submission-reminder',
    //             ['submissions' => $submissions],
    //             function ($message) use ($to, $cc) {
    //                 $message->to($to)
    //                     ->cc($cc)
    //                     ->subject('📌 WAITING RECEIVED SUBMISSION REMINDER - ' . now()->format('d M Y'));
    //             }
    //         );

    //         $this->info(
    //             'Waiting Received reminder sent. Total submissions: ' . $submissions->count()
    //         );
    //     } else {
    //         $this->info('No submissions with status Waiting Received found.');
    //     }

    //     return Command::SUCCESS;
    // }

    public function handle()
    {
        // Ambil SEMUA submission dengan status Waiting Received
        $submissions = Submission::where('status', 'Waiting Received')
            ->orderBy('due_date', 'asc')
            ->get();

        if ($submissions->count() > 0) {

            $to = 'sek.esd@siix-global.com';
            $cc = 'widifajarsatritama@gmail.com';

            Mail::send(
                'emails.DCC.due-submission-reminder',
                ['submissions' => $submissions],
                function ($message) use ($to, $cc) {
                    $message->to($to)
                        ->cc($cc)
                        ->subject('📌 WAITING RECEIVED SUBMISSION REMINDER - ' . now()->format('d M Y'));
                }
            );

            $this->info(
                'Waiting Received reminder sent. Total submissions: ' . $submissions->count()
            );
        } else {
            $this->info('No submissions with status Waiting Received found.');
        }

        return Command::SUCCESS;
    }
}

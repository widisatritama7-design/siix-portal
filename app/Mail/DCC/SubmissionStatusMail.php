<?php

namespace App\Mail\DCC;

use App\Models\DCC\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public Submission $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->subject("Update Submission Status: {$this->submission->description}")
                    ->view('emails.DCC.submission_status')
                    ->with([
                        'submission' => $this->submission,
                    ]);
    }
}

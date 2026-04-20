<?php

namespace App\Mail\DCC;

use App\Models\DCC\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionDistributedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Submission $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->subject("Document Distributed: {$this->submission->description}")
                    ->view('emails.dcc.submission_distributed')
                    ->with([
                        'submission' => $this->submission,
                    ]);
    }
}
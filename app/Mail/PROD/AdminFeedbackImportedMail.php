<?php

namespace App\Mail\PROD;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminFeedbackImportedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Feedback Imported - Uniform Request #' . $this->request->request_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.prod.admin-feedback-imported',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
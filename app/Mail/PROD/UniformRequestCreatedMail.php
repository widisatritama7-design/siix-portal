<?php

namespace App\Mail\PROD;

use App\Models\PROD\Uniform\UniformRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UniformRequestCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $isUpdate;

    public function __construct(UniformRequest $request, $isUpdate = false)
    {
        $this->request = $request;
        $this->isUpdate = $isUpdate;
    }

    public function envelope(): Envelope
    {
        $subject = $this->isUpdate 
            ? 'Uniform Request Updated - ' . $this->request->request_number
            : 'New Uniform Request Created - ' . $this->request->request_number;
            
        return new Envelope(
            subject: $subject,
            to: [
                'widifajarsatritama@gmail.com',
                'sek.esd@siix-global.com',
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.prod.uniform-request-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
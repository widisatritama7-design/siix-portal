<?php

namespace App\Mail\ESD;

use App\Models\ESD\Garment\UniformRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UniformNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public UniformRecipient $recipient;
    public string $emailSubject;
    public string $emailMessage;
    public string $emailMethod;
    public string $methodLabel;
    public string $methodColor;
    public string $actionText;

    public function __construct(
        UniformRecipient $recipient,
        string $subject,
        string $message,
        string $method
    ) {
        $this->recipient = $recipient;
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
        $this->emailMethod = $method;

        if ($method === 'info_esd') {
            $this->methodLabel = 'ESD Garment Measurement';
            $this->methodColor = '#2563eb'; // blue
            $this->actionText  = 'Mohon Membawa Seragam Lengkap (1 Set)';
        } else {
            $this->methodLabel = 'Reminder: ESD Garment Measurement';
            $this->methodColor = '#d97706'; // amber
            $this->actionText  = 'Segera Membawa Seragam Anda';
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->emailSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.esd.uniform-notification',
            with: [
                'recipient'   => $this->recipient,
                'subject'     => $this->emailSubject,
                'messageBody' => $this->emailMessage,
                'methodLabel' => $this->methodLabel,
                'methodColor' => $this->methodColor,
                'actionText'  => $this->actionText,
                'emailMethod' => $this->emailMethod,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
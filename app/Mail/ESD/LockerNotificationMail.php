<?php

namespace App\Mail\ESD;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LockerNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        $subject = match($this->data['type'] ?? '') {
            'store' => 'ESD Locker - Konfirmasi Penyimpanan Seragam',
            'take' => 'ESD Locker - Konfirmasi Pengambilan Seragam',
            'checking' => 'ESD Locker - Proses Pengecekan Seragam',
            'ready' => 'ESD Locker - Seragam Siap Diambil!',
            'ready_with_measurement' => 'ESD Locker - Seragam Siap Diambil!',
            'ng' => 'ESD Locker - Pemberitahuan NG',
            default => 'ESD Locker - Notifikasi'
        };

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $view = match($this->data['type'] ?? '') {
            'checking' => 'emails.esd.locker-checking',
            'ready' => 'emails.esd.locker-ready',
            'ready_with_measurement' => 'emails.esd.locker-ready-with-measurement',
            'ng' => 'emails.esd.locker-ng',
            default => 'emails.esd.locker-notification'
        };

        return new Content(
            view: $view,
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
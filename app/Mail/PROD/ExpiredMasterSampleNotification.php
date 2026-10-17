<?php

namespace App\Mail\PROD;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpiredMasterSampleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $expiredSamples,
        public string $periodLabel
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "⚠️ Reminder: Master Sample Expired Bulan {$this->periodLabel} (" . $this->expiredSamples->count() . " item)",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.prod.expired-master-sample',
            with: [
                'samples'     => $this->expiredSamples,
                'periodLabel' => $this->periodLabel,
                'total'       => $this->expiredSamples->count(),
            ],
        );
    }

    public function attachments(): array
    {
        // Generate PDF dari view terpisah
        $pdf = Pdf::loadView('emails.prod.expired-master-sample-pdf', [
            'samples'     => $this->expiredSamples,
            'periodLabel' => $this->periodLabel,
            'generatedAt' => now()->format('d M Y H:i'),
            'total'       => $this->expiredSamples->count(),
        ])->setPaper('a4', 'landscape');

        $filename = 'master-sample-expired-'
            . now()->format('Y-m') . '.pdf';

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                $filename
            )->withMime('application/pdf'),
        ];
    }
}
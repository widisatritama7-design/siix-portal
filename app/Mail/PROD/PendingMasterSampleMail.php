<?php

namespace App\Mail\PROD;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingMasterSampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $type;
    public $total;

    public function __construct($user, string $type, int $total)
    {
        $this->user = $user;
        $this->type = $type;
        $this->total = $total;
    }

    public function build()
    {
        return $this
            ->subject("Pending Master Sample: {$this->type}")
            ->view('emails.prod.pending-master-sample-single')
            ->with([
                'user' => $this->user,
                'type' => $this->type,
                'total' => $this->total,
            ]);
    }
}

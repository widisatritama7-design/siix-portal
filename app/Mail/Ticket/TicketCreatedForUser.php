<?php

namespace App\Mail\Ticket;

use App\Models\Ticket\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreatedForUser extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->view('emails.ticket.created_for_user')
            ->with([
                'ticket' => $this->ticket,
            ]);
    }
}

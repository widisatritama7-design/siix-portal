<?php

namespace App\Mail\Ticket;

use App\Models\Ticket\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this
            ->subject('New Ticket : ' . $this->ticket->ticket_number)
            ->view('emails.ticket.created')
            ->with(['ticket' => $this->ticket]);
    }
}

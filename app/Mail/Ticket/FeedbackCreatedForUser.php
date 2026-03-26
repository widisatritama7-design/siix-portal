<?php

namespace App\Mail\Ticket;

use App\Models\Ticket\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackCreatedForUser extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function build()
    {
        return $this->subject('Update on Your Ticket #' . $this->feedback->ticket->ticket_number)
                    ->view('emails.ticket.feedback_created_for_user');
    }
}
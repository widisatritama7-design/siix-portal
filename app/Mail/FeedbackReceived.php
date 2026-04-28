<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackReceived extends Mailable
{
    use Queueable, SerializesModels;

    public array $feedback;

    public function __construct(array $feedback)
    {
        $this->feedback = $feedback;
    }

    public function build()
    {
        return $this->subject('Feedback Baru Diterima')
                    ->view('emails.feedback-received')
                    ->with([
                        'feedbackName' => $this->feedback['name'] ?? 'Anonymous',
                        'feedbackEmail' => $this->feedback['email'] ?? 'N/A',
                        'feedbackCategory' => $this->feedback['category'] ?? 'general',
                        'feedbackMessage' => $this->feedback['message'] ?? '',

                        // User info tambahan
                        'feedbackIP' => $this->feedback['user_info']['ip'] ?? null,
                        'feedbackUserAgent' => $this->feedback['user_info']['user_agent'] ?? null,
                        'feedbackURL' => $this->feedback['user_info']['url'] ?? null,
                        'feedbackLanguage' => $this->feedback['user_info']['language'] ?? null,
                        'feedbackUserName' => $this->feedback['user_info']['user_name'] ?? 'Anonymous',
                        'feedbackViewportWidth' => $this->feedback['user_info']['viewportWidth'] ?? null,
                        'feedbackViewportHeight' => $this->feedback['user_info']['viewportHeight'] ?? null,
                    ]);
    }

}

<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Queueable;

    protected $phone;
    protected $message;
    protected $transactionId;

    public function __construct($phone, $message, $transactionId = null)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->transactionId = $transactionId;
    }

    public function handle(WhatsAppService $whatsapp)
    {
        try {
            if (!$this->phone) {
                Log::warning('WhatsApp job skipped: No phone number', [
                    'transaction_id' => $this->transactionId
                ]);
                return;
            }

            $whatsapp->send($this->phone, $this->message);
            
            Log::info('WhatsApp queue job completed', [
                'phone' => $this->phone,
                'transaction_id' => $this->transactionId
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp queue job failed: ' . $e->getMessage(), [
                'phone' => $this->phone,
                'transaction_id' => $this->transactionId
            ]);
            
            // Retry jika gagal
            if ($this->attempts() < 3) {
                $this->release(60); // Retry setelah 60 detik
            }
        }
    }
}
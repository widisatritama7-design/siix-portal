<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $url;

    public function __construct()
    {
        $this->url = rtrim(
            config('services.whatsapp.url', env('WHATSAPP_API_URL', 'http://127.0.0.1:3001')),
            '/'
        );
    }

    /**
     * Kirim pesan teks biasa
     */
    public function send(string $phone, string $message): array
    {
        try {
            Log::info('Sending WhatsApp message', [
                'phone' => $phone,
                'url' => $this->url . '/send-whatsapp'
            ]);

            $response = Http::timeout(10)
                ->retry(2, 100)
                ->post(
                    $this->url . '/send-whatsapp',
                    [
                        'phone' => $phone,
                        'message' => $message,
                    ]
                );

            if ($response->failed()) {
                Log::error('WhatsApp API response failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception(
                    $response->json('message') ?? 'Gagal mengirim WhatsApp'
                );
            }

            Log::info('WhatsApp sent successfully', [
                'phone' => $phone,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp send error', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Kirim WhatsApp dengan gambar QR Code
     */
    public function sendWithQRImage(string $phone, string $message, string $qrImagePath): array
    {
        try {
            Log::info('Sending WhatsApp with QR Image', [
                'phone' => $phone,
                'image_path' => $qrImagePath
            ]);

            // Cek apakah file gambar ada
            if (!file_exists($qrImagePath)) {
                throw new Exception('QR Image file not found: ' . $qrImagePath);
            }

            // Kirim dengan multipart form-data
            $response = Http::timeout(15)
                ->attach(
                    'image', 
                    file_get_contents($qrImagePath), 
                    'qr_code.png'
                )
                ->post(
                    $this->url . '/send-whatsapp-image',
                    [
                        'phone' => $phone,
                        'message' => $message,
                    ]
                );

            if ($response->failed()) {
                Log::error('WhatsApp with QR Image response failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new Exception(
                    $response->json('message') ?? 'Gagal mengirim WhatsApp dengan gambar'
                );
            }

            Log::info('WhatsApp with QR Image sent successfully', [
                'phone' => $phone,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp with QR Image send error: ' . $e->getMessage(), [
                'phone' => $phone
            ]);
            
            // Fallback: kirim teks biasa dengan link QR Code
            $qrUrl = asset('storage/qr_codes/' . basename($qrImagePath));
            $fallbackMessage = $message . "\n\n📱 *Scan QR Code:*\n" . $qrUrl;
            return $this->send($phone, $fallbackMessage);
        }
    }

    public function status(): array
    {
        try {
            return Http::timeout(5)
                ->get($this->url . '/status')
                ->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp status check error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
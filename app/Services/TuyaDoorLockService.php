<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TuyaDoorLockService
{
    private string $baseUrl;
    private string $clientId;
    private string $secret;
    private string $accessToken;

    public function __construct()
    {
        // FIX: Base URL tanpa /v1.0
        $this->baseUrl = rtrim(env('TUYA_BASE_URL'), '/');
        $this->clientId = env('TUYA_CLIENT_ID');
        $this->secret = env('TUYA_CLIENT_SECRET');
        $this->accessToken = env('TUYA_ACCESS_TOKEN');
    }

    public function createPasswordTicket(string $deviceId): array
    {
        $timestamp = (string) round(microtime(true) * 1000);
        $path = "/v1.0/devices/{$deviceId}/door-lock/password-ticket";
        $method = "POST";
        $body = "";

        $sign = $this->generateSign($method, $path, $body, $timestamp);

        $response = Http::withHeaders([
            'client_id' => $this->clientId,
            'access_token' => $this->accessToken,
            't' => $timestamp,
            'sign_method' => 'HMAC-SHA256',
            'sign' => $sign,
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false, // TEMPORARY - Hanya untuk testing
        ])->post($this->baseUrl . $path);

        return $response->json();
    }

    public function createTempPassword(string $deviceId, array $ticket, int $start, int $end, string $name = 'Guest'): array
    {
        $timestamp = (string) round(microtime(true) * 1000);
        $path = "/v1.0/devices/{$deviceId}/door-lock/temp-password";
        $method = "POST";

        $payload = [
            'ticket_id' => $ticket['ticket_id'],
            'ticket_key' => $ticket['ticket_key'],
            'name' => $name,
            'effective_time' => $start,
            'invalid_time' => $end,
            'password_type' => 'ticket',
        ];

        $body = json_encode($payload);
        $sign = $this->generateSign($method, $path, $body, $timestamp);

        $response = Http::withHeaders([
            'client_id' => $this->clientId,
            'access_token' => $this->accessToken,
            't' => $timestamp,
            'sign_method' => 'HMAC-SHA256',
            'sign' => $sign,
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false, // TEMPORARY - Hanya untuk testing
        ])->post($this->baseUrl . $path, $payload);

        return $response->json();
    }

    /**
     * FIXED SIGNATURE GENERATION
     */
    private function generateSign(string $method, string $path, string $body, string $timestamp): string
    {
        $method = strtoupper($method);
        
        // BODY HASH
        $contentHash = strtoupper(hash('sha256', $body));
        
        // FIX: String to sign format yang benar
        $stringToSign = $method . "\n" . $contentHash . "\n\n" . $path;
        
        // FIX: Sign string
        $signStr = $this->clientId . $this->accessToken . $timestamp . $stringToSign;
        
        return strtoupper(hash_hmac('sha256', $signStr, $this->secret));
    }
}
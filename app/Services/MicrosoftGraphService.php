<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MicrosoftGraphService
{
    public function getAccessToken()
    {
        $response = Http::asForm()->post(
            'https://login.microsoftonline.com/' .
            config('services.microsoft.tenant_id') .
            '/oauth2/v2.0/token',
            [
                'client_id' => config('services.microsoft.client_id'),
                'client_secret' => config('services.microsoft.client_secret'),
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ]
        );

        if ($response->failed()) {
            throw new \Exception(
                'Microsoft authentication failed: ' .
                $response->body()
            );
        }

        return $response->json('access_token');
    }

    public function testSender()
    {
        $token = $this->getAccessToken();

        $sender = config('services.microsoft.sender_email');

        $response = Http::withToken($token)
            ->acceptJson()
            ->get(
                'https://graph.microsoft.com/v1.0/users/' .
                rawurlencode($sender)
            );

        return $response;
    }

    public function sendEmail(
        string $to,
        string $subject,
        string $body
    ) {
        $token = $this->getAccessToken();

        $sender = config('services.microsoft.sender_email');

        $response = Http::withToken($token)
            ->post(
                "https://graph.microsoft.com/v1.0/users/{$sender}/sendMail",
                [
                    'message' => [
                        'subject' => $subject,

                        'body' => [
                            'contentType' => 'HTML',
                            'content' => $body,
                        ],

                        'toRecipients' => [
                            [
                                'emailAddress' => [
                                    'address' => $to,
                                ],
                            ],
                        ],
                    ],

                    'saveToSentItems' => true,
                ]
            );

        if ($response->failed()) {
            throw new \Exception(
                'Microsoft email failed: ' . $response->body()
            );
        }

        return true;
    }
}
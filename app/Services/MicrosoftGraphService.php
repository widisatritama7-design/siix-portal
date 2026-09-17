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

    public function sendApprovalEmail(
        string $to,
        string $requestId
    ) {
        $token = $this->getAccessToken();

        $sender = config('services.microsoft.sender_email');

        $html = '
            <html>
            <body>

            <h2>ESD Approval Request</h2>

            <p>
                Terdapat request ESD yang membutuhkan approval.
            </p>

            <p>
                <strong>Request ID:</strong> ' . e($requestId) . '
            </p>

            <script type="application/adaptivecard+json">
            {
                "$schema": "http://adaptivecards.io/schemas/adaptive-card.json",
                "type": "AdaptiveCard",
                "version": "1.0",
                "originator": "",
                "body": [
                    {
                        "type": "TextBlock",
                        "text": "ESD Approval Request",
                        "weight": "Bolder",
                        "size": "Medium"
                    },
                    {
                        "type": "TextBlock",
                        "text": "Request ID: ' . e($requestId) . '",
                        "wrap": true
                    },
                    {
                        "type": "TextBlock",
                        "text": "Comment",
                        "wrap": true
                    },
                    {
                        "type": "Input.Text",
                        "id": "comment",
                        "placeholder": "Masukkan komentar..."
                    }
                ],
                "actions": [
                    {
                        "type": "Action.Http",
                        "title": "APPROVE",
                        "method": "POST",
                        "url": "https://test.siix-ems.co.id/api/approval/action",
                        "headers": [
                            {
                                "name": "Content-Type",
                                "value": "application/json"
                            }
                        ],
                        "body": "{\\"action\\":\\"approve\\",\\"request_id\\":\\"' . e($requestId) . '\\",\\"comment\\":\\"{{comment.value}}\\"}"
                    },
                    {
                        "type": "Action.Http",
                        "title": "REJECT",
                        "method": "POST",
                        "url": "https://test.siix-ems.co.id/api/approval/action",
                        "headers": [
                            {
                                "name": "Content-Type",
                                "value": "application/json"
                            }
                        ],
                        "body": "{\\"action\\":\\"reject\\",\\"request_id\\":\\"' . e($requestId) . '\\",\\"comment\\":\\"{{comment.value}}\\"}"
                    }
                ]
            }
            </script>

            </body>
            </html>
        ';

        $response = Http::withToken($token)
            ->post(
                "https://graph.microsoft.com/v1.0/users/{$sender}/sendMail",
                [
                    'message' => [
                        'subject' => 'ESD Approval Request - ' . $requestId,

                        'body' => [
                            'contentType' => 'HTML',
                            'content' => $html,
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
                'Microsoft approval email failed: ' . $response->body()
            );
        }

        return true;
    }
}
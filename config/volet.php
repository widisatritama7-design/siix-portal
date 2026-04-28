<?php

return [
    // The icon that will be shown in the button bubble. Can be a SVG or an image URL
    'icon' => 'https://api.iconify.design/heroicons:chat-bubble-left-ellipsis.svg?color=%23FFFFFF',

    /*
    |--------------------------------------------------------------------------
    | Features Configuration
    |--------------------------------------------------------------------------
    |
    | Configure settings for individual features.
    |
    */
    'feedback-messages' => [
        'table' => 'volet_feedback_messages',
        'controller' => \App\Http\Controllers\FeedbackController::class,
        'model' => \Mydnic\Volet\Models\FeedbackMessage::class,
        'routes' => [
            'prefix' => 'feedback',
            'middleware' => ['web'],
        ],
        'content' => [
            'success-icon' => 'https://api.iconify.design/heroicons:check-circle.svg?color=%2322c55e',
        ],
        'mail_notification' => [
            'enabled' => true,
            'send_mails_to' => [
                'sek.esd@siix-global.com',
            ],
            'class' => \Mydnic\Volet\Notifications\NewFeedbackMessageNotification::class,
        ],
    ],

];

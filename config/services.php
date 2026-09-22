<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'razorpay' => [
        'key' => env('RAZORPAY_KEY_ID', env('RAZORPAY_KEY', '')),
        'secret' => env('RAZORPAY_KEY_SECRET', env('RAZORPAY_SECRET', '')),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', ''),
        'verify_ssl' => env('RAZORPAY_VERIFY_SSL', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Service (MSG91 / Twilio — set SMS_ENABLED=true when keys are ready)
    |--------------------------------------------------------------------------
    */
    'sms' => [
        'enabled' => env('SMS_ENABLED', false),
        'provider' => env('SMS_PROVIDER', 'msg91'),
        'msg91' => [
            'auth_key' => env('MSG91_AUTH_KEY'),
            'sender_id' => env('MSG91_SENDER_ID', 'OUTSLAB'),
            'template_id' => env('MSG91_TEMPLATE_ID'),
        ],
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Service (Interakt / AiSensy — set WHATSAPP_ENABLED=true when ready)
    |--------------------------------------------------------------------------
    */
    'whatsapp' => [
        'enabled' => env('WHATSAPP_ENABLED', false),
        'provider' => env('WHATSAPP_PROVIDER', 'interakt'),
        'interakt' => [
            'api_key' => env('INTERAKT_API_KEY'),
        ],
        'aisensy' => [
            'api_key' => env('AISENSY_API_KEY'),
        ],
    ],

];

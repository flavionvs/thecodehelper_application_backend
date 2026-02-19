<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe
    |--------------------------------------------------------------------------
    |
    | Stripe configuration for payments and transfers.
    | Secret key MUST stay backend-only.
    |
    */

    'stripe' => [
        'secret' => env('STRIPE_SECRET_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'connect_return_url' => env('STRIPE_CONNECT_RETURN_URL', 'https://thecodehelper.com/user/account'),
        'connect_refresh_url' => env('STRIPE_CONNECT_REFRESH_URL', 'https://thecodehelper.com/user/account'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SendGrid
    |--------------------------------------------------------------------------
    |
    | SendGrid configuration for transactional emails.
    |
    */

    'sendgrid' => [
        'api_key' => env('Send_Grid_API'),
    ],

];


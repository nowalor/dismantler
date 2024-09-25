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
        'scheme' => 'https',
    ],

    'paypal' => [
        'base_uri' => env('PAYPAL_BASE_URI'),
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'class' => App\Services\PayPalService::class,
    ],

    'stripe' => [
        'base_uri' => env('STRIPE_BASE_URI'),
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'class' => App\Services\StripeService::class,
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'fenix_api' => [
        'base_uri' => env('FENIX_BASE_URI'),
        'email' => env('FENIX_EMAIL'),
        'password' => env('FENIX_PASSWORD'),
    ],

    'slack' => [
        'order_webhook_url' => env('SLACK_WEBHOOK_ORDER'),
        'order_failed_webhook_url' => env('SLACK_WEBHOOK_ORDER_ERROR'),
    ],

    'ebay' => [
        'app_id' => env('EBAY_APP_ID'),
        'dev_id' => env('EBAY_DEV_ID'),
        'cert_id' => env('EBAY_CERT_ID'),
        'api_url' => env('EBAY_API_URL'),
    ],

    'hood' => [
        'api_url' => env('HOOD_DE_API_URL'),
        'username' => env('HOOD_DE_USERNAME'),
        'api_password' => env('HOOD_DE_API_PASSWORD'),
    ],

    'nummerplade' => [
        'api_url' => env('NUMMERPLADE_API_URL') ?? 'hey',
        'token' => env('NUMMERPLADE_API_TOKEN'),
    ]
];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */
    'google' => [
        'maps_key' => env('GOOGLE_MAPS_KEY'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'rollbar' => [
        'access_token' => env('ROLLBAR_TOKEN'),
        'level' => env('ROLLBAR_LEVEL', 'error'),
        'js_token' => env('ROLLBAR_TOKEN_JS'),
        'person_fn' => 'get_rollbar_person',
    ],

    'pusher' => [
        'auth_key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
    ],

    'braintree' => [
        'env' => env('BRAINTREE_ENV', 'sandbox'),
        'merchant_id' => env('BRAINTREE_MERCHANT_ID', 'merchant_id'),
        'public_key' => env('BRAINTREE_PUBLIC_KEY', 'public_key'),
        'private_key' => env('BRAINTREE_PRIVATE_KEY', 'private_key'),
    ],
];

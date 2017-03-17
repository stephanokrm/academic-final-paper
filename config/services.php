<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],
    
    'mandrill' => [
        'secret' => '',
    ],
    
    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],
    
    'stripe' => [
        'model' => 'App\User',
        'secret' => '',
    ],
    
    'firebase' => [
        'api_key' => 'AIzaSyAradgZ47xKc5sNDipKNntfNrVUf-3mcyI',
        'auth_domain' => 'academic-132223.firebaseapp.com',
        'database_url' => 'https://academic-132223.firebaseio.com',
        'secret' => 'iWkPrnHAI3pKJjuPrwJcFomI8AE4rocDbFJ2swgk',
        'storage_bucket' => 'academic-132223.appspot.com',
    ],
];

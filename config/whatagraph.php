<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Whatagraph Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for Whatagraph APIs
    |
    */

    'base_url' => env('WG_BASE_URL', 'https://api.whatagraph.com'),

    /*
    |--------------------------------------------------------------------------
    | Whatagraph Access Token
    |--------------------------------------------------------------------------
    |
    | The access token from whatagraph.com
    |
    */

    'access_token' => env('WG_ACCESS_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Whatagraph Structure
    |--------------------------------------------------------------------------
    |
    | The metrics/dimension structure of Whatagraph report
    |
    */

    'metrics' => [
        [
            'name' => 'Temperature',
            'external_id' => 'temp',
            'type' => 'float'
        ],
        [
            'name' => 'Feels Like',
            'external_id' => 'feels_like',
            'type' => 'float'
        ],
        [
            'name' => 'Pressure',
            'external_id' => 'pressure',
            'type' => 'float'
        ],
        [
            'name' => 'Humidity',
            'external_id' => 'humidity',
            'type' => 'float'
        ],
        [
            'name' => 'UVI',
            'external_id' => 'uvi',
            'type' => 'float'
        ],
        [
            'name' => 'Clouds',
            'external_id' => 'clouds',
            'type' => 'float'
        ],
        [
            'name' => 'Visibility',
            'external_id' => 'visibility',
            'type' => 'float'
        ],
        [
            'name' => 'Wind Speed',
            'external_id' => 'wind_speed',
            'type' => 'float'
        ],
        [
            'name' => 'Wind Deg',
            'external_id' => 'wind_deg',
            'type' => 'float'
        ],
        [
            'name' => 'Wind Gust',
            'external_id' => 'wind_gust',
            'type' => 'float'
        ],
    ],

    'dimensions' => [
        [
            'name' => 'City',
            'external_id' => 'city',
            'type' => 'string'
        ]
    ]

];

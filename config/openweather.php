<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenWeather Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for openweathermap APIs
    |
    */

    'base_url' => env('OPENWEATHER_BASE_URL', 'https://api.openweathermap.org'),

    /*
    |--------------------------------------------------------------------------
    | OpenWeather
    |--------------------------------------------------------------------------
    |
    | The secret API key from https://openweathermap.org/
    |
    */

    'api_key' => env('OPENWEATHER_API_KEY', ''),

];

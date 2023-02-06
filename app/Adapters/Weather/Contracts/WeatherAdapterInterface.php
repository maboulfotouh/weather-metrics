<?php
namespace App\Adapters\Weather\Contracts;

use App\Data\LocationWeatherData;

interface WeatherAdapterInterface
{
    public function getLocationWeather(string $latitude, string $longitude): LocationWeatherData;
}

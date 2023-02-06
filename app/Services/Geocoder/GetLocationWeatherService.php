<?php
namespace App\Services\Geocoder;

use App\Adapters\Weather\Contracts\WeatherAdapterInterface;
use App\Data\LocationWeatherData;

class GetLocationWeatherService
{
    private WeatherAdapterInterface $weatherAdapter;

    public function __construct(WeatherAdapterInterface $weatherAdapter)
    {
        $this->weatherAdapter = $weatherAdapter;
    }

    public function execute(string $latitude, string $longitude): LocationWeatherData
    {
        return $this->weatherAdapter->getLocationWeather($latitude, $longitude);
    }
}

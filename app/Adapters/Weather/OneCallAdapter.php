<?php
namespace App\Adapters\Weather;

use App\Adapters\Weather\Contracts\WeatherAdapterInterface;
use App\Adapters\Weather\OneCall\LocationWeatherRequest;
use App\Data\LocationWeatherData;
use App\Exceptions\OpenWeatherException;

class OneCallAdapter implements WeatherAdapterInterface
{
    /**
     * @param string $latitude
     * @param string $longitude
     * @return LocationWeatherData
     * @throws OpenWeatherException
     */
    public function getLocationWeather(string $latitude, string $longitude): LocationWeatherData
    {
        return (new LocationWeatherRequest($latitude, $longitude))->locationWeatherDTO();
    }
}

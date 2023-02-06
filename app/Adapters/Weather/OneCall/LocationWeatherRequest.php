<?php
namespace App\Adapters\Weather\OneCall;

use App\Adapters\OpenWeatherClient;
use App\Data\LocationWeatherData;
use App\Exceptions\OpenWeatherException;

class LocationWeatherRequest extends OpenWeatherClient
{
    const ENDPOINT = '/data/3.0/onecall';
    private string $latitude;
    private string $longitude;

    public function __construct(string $latitude, string $longitude)
    {
        parent::__construct();
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @throws OpenWeatherException
     */
    public function locationWeatherDTO(): LocationWeatherData
    {
        $URL = $this->urlBuilder(self::ENDPOINT, [
            'lat' => $this->latitude,
            'lon' => $this->longitude
        ]);
        $response = $this->fire($URL)->json();

        return LocationWeatherData::from($response['current']);
    }
}

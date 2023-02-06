<?php
namespace App\Data;

use Spatie\LaravelData\{Data, Optional};
class LocationData extends Data
{
    public function __construct(
        public string $name,
        public string $country,
        public string|Optional $state,
        public string $lat,
        public string $lon,
        public LocationWeatherData|Optional $locationWeatherData
    ) {
    }
}

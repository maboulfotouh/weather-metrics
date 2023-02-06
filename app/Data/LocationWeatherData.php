<?php
namespace App\Data;

use App\Data\Casts\CarbonCast;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\{Data, Optional};
class LocationWeatherData extends Data
{
    public function __construct(
        #[WithCast(CarbonCast::class)]
        public Carbon $dt,
        #[WithCast(CarbonCast::class)]
        public Carbon $sunrise,
        #[WithCast(CarbonCast::class)]
        public Carbon $sunset,
        public float $temp,
        public float $feels_like,
        public float $pressure,
        public float $humidity,
        public float $dew_point,
        public float $uvi,
        public float $clouds,
        public float $visibility,
        public float $wind_speed,
        public float $wind_deg,
        public float|Optional $wind_gust

    ) {
    }
}

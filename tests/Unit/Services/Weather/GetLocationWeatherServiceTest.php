<?php
namespace Tests\Unit\Services\Weather;

use App\Exceptions\OpenWeatherException;
use App\Services\Weather\GetLocationWeatherService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetLocationWeatherServiceTest extends TestCase
{
    use WithFaker;

    const URL = 'https://api.openweathermap.org/data/3.0/onecall*';

    protected const WEATHER_DATA = [
        'lat' => 11.11,
        'lon' => 12.12,
        'timezone' => 'Africa/Cairo',
        'timezone_offset' => 7200,
        'current' => [
            'dt' => 1675587281,
            'sunrise' => 1675587281,
            'sunset' => 1675587281,
            'temp' => 1,
            'feels_like' => 2,
            'pressure' => 3,
            'humidity' => 4,
            'dew_point' => 5,
            'uvi' => 6,
            'clouds' => 7,
            'visibility' => 8,
            'wind_speed' => 9,
            'wind_deg' => 10,
            'wind_gust' => 11
        ]
    ];

    private GetLocationWeatherService $getLocationWeatherService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getLocationWeatherService = $this->app->make('App\Services\Weather\GetLocationWeatherService');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_location_weather_service()
    {
        Http::fake([
            self::URL => HTTP::response(self::WEATHER_DATA)
        ]);
        $locationData = $this->getLocationWeatherService->execute('11.11', '12.12');

        $this->assertEquals(self::WEATHER_DATA['current']['temp'], $locationData->temp);
        $this->assertEquals(self::WEATHER_DATA['current']['feels_like'], $locationData->feels_like);
        $this->assertEquals(self::WEATHER_DATA['current']['pressure'], $locationData->pressure);
        $this->assertEquals(self::WEATHER_DATA['current']['humidity'], $locationData->humidity);
        $this->assertEquals(self::WEATHER_DATA['current']['dew_point'], $locationData->dew_point);
        $this->assertEquals(self::WEATHER_DATA['current']['uvi'], $locationData->uvi);
        $this->assertEquals(self::WEATHER_DATA['current']['clouds'], $locationData->clouds);
        $this->assertEquals(self::WEATHER_DATA['current']['visibility'], $locationData->visibility);
        $this->assertEquals(self::WEATHER_DATA['current']['wind_speed'], $locationData->wind_speed);
        $this->assertEquals(self::WEATHER_DATA['current']['wind_deg'], $locationData->wind_deg);
        $this->assertEquals(self::WEATHER_DATA['current']['wind_gust'], $locationData->wind_gust);
    }

    public function test_failed_for_location_weather_service()
    {
        Http::fake([
            self::URL => HTTP::response('', 500)
        ]);
        $this->expectException(OpenWeatherException::class);
        $this->getLocationWeatherService->execute('11.11', '12.12');
    }
}

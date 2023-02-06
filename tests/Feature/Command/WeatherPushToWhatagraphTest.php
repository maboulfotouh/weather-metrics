<?php
namespace Tests\Feature\Command;

use App\Services\Geocoder\SearchLocationService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherPushToWhatagraphTest extends TestCase
{
    use WithFaker;

    const GEOCODER_URL = 'https://api.openweathermap.org/geo/1.0/direct*';
    const ONECALL_URL = 'https://api.openweathermap.org/data/3.0/onecall*';
    const WG_SUBMIT_SOURCE_DATA = 'https://api.whatagraph.com/v1/integration-source-data/*';

    protected const LOCATIONS_DATA = [
        [
            'name' => 'First Location',
            'lat' => '111',
            'lon' => '222',
            'state' => 'Cairo',
            'country' => 'Egypt',
        ],
        [
            'name' => 'Second Location',
            'lat' => '333',
            'lon' => '444',
            'state' => 'London',
            'country' => 'UK',
        ]
    ];

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

    private SearchLocationService $searchForLocationService;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_weather_push_to_whatagraph_cli()
    {
        Http::fake([
            self::WG_SUBMIT_SOURCE_DATA => HTTP::response(),
            self::GEOCODER_URL => HTTP::response(self::LOCATIONS_DATA),
            self::ONECALL_URL => HTTP::response(self::WEATHER_DATA),
        ]);
        $this->artisan('weather:pull-and-push-to-whatagraph')
            ->expectsQuestion('Please enter the location name', 'Cairo')
            ->expectsChoice('Choose a search result from the following', 0, [
                'First Location - Cairo - Egypt',
                'Second Location - London - UK'
            ])->expectsConfirmation('Would you like to submit another location?', 'no')
            ->expectsOutput('Data pushed to Whatagraph successfully')
            ->assertExitCode(Command::SUCCESS);
    }
}

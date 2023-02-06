<?php
namespace Tests\Unit\Services\Whatagraph;

use App\Data\LocationData;
use App\Exceptions\WGException;
use App\Services\Whatagraph\CreateLocationSourceDataService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateLocationSourceDataServiceTest extends TestCase
{
    use WithFaker;

    private const URL = 'https://api.whatagraph.com/v1/integration-source-data/*';

    private const LOCATIONS = [
        [
            'name' => 'First Location',
            'lat' => '111',
            'lon' => '222',
            'state' => 'Cairo',
            'country' => 'Egypt',
            'locationWeatherData' => [
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
        ],
        [
            'name' => 'Second Location',
            'lat' => '333',
            'lon' => '444',
            'state' => 'London',
            'country' => 'UK',
            'locationWeatherData' => [
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
        ]
    ];

    private CreateLocationSourceDataService $createLocationSourceDataService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createLocationSourceDataService = $this->app->make('App\Services\Whatagraph\CreateLocationSourceDataService');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_location_source_data_service()
    {
        Http::fake([
            self::URL => HTTP::response()
        ]);
        $locationOne = LocationData::from(self::LOCATIONS[0]);
        $locationTwo = LocationData::from(self::LOCATIONS[1]);
        $locations = collect()->push($locationOne)->push($locationTwo);
        $this->createLocationSourceDataService->execute($locations);
        $this->assertTrue(true);
    }

    public function test_failed_to_create_location_source()
    {
        Http::fake([
            self::URL => HTTP::response('', 500)
        ]);
        $this->expectException(WGException::class);
        $locationOne = LocationData::from(self::LOCATIONS[0]);
        $locationTwo = LocationData::from(self::LOCATIONS[1]);
        $locations = collect()->push($locationOne)->push($locationTwo);
        $this->createLocationSourceDataService->execute($locations);
    }
}

<?php
namespace Tests\Unit\Services\Geocoder;

use App\Exceptions\OpenWeatherException;
use App\Services\Geocoder\SearchLocationService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SearchLocationServiceTest extends TestCase
{
    use WithFaker;

    const URL = 'https://api.openweathermap.org/geo/1.0/direct*';

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

    private SearchLocationService $searchForLocationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->searchForLocationService = $this->app->make('App\Services\Geocoder\SearchLocationService');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_search_for_location_service()
    {
        Http::fake([
            self::URL => HTTP::response(self::LOCATIONS_DATA)
        ]);
        $locations = $this->searchForLocationService->execute('test');

        $firstLocation = $locations->offsetGet(0);
        $this->assertEquals(self::LOCATIONS_DATA[0]['name'], $firstLocation->name);
        $this->assertEquals(self::LOCATIONS_DATA[0]['lat'], $firstLocation->lat);
        $this->assertEquals(self::LOCATIONS_DATA[0]['lon'], $firstLocation->lon);
        $this->assertEquals(self::LOCATIONS_DATA[0]['state'], $firstLocation->state);
        $this->assertEquals(self::LOCATIONS_DATA[0]['country'], $firstLocation->country);

        $secondLocation = $locations->offsetGet(1);
        $this->assertEquals(self::LOCATIONS_DATA[1]['name'], $secondLocation->name);
        $this->assertEquals(self::LOCATIONS_DATA[1]['lat'], $secondLocation->lat);
        $this->assertEquals(self::LOCATIONS_DATA[1]['lon'], $secondLocation->lon);
        $this->assertEquals(self::LOCATIONS_DATA[1]['state'], $secondLocation->state);
        $this->assertEquals(self::LOCATIONS_DATA[1]['country'], $secondLocation->country);
    }

    public function test_failed_for_search_location()
    {
        Http::fake([
            self::URL => HTTP::response('', 500)
        ]);
        $this->expectException(OpenWeatherException::class);
        $this->searchForLocationService->execute('test');
    }
}

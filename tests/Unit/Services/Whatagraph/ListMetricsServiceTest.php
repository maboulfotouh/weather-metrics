<?php
namespace Tests\Unit\Services\Whatagraph;

use App\Exceptions\WGException;
use App\Services\Whatagraph\ListMetricsService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListMetricsServiceTest extends TestCase
{
    use WithFaker;

    private const URL = 'https://api.whatagraph.com/v1/integration-metrics/*';

    private const METRICS = [
        [
            "id" => 37140,
            "external_id" => "temp",
            "name" => "Temperature",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37141,
            "external_id" => "feels_like",
            "name" => "Feels Like",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37142,
            "external_id" => "pressure",
            "name" => "Pressure",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37143,
            "external_id" => "humidity",
            "name" => "Humidity",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37144,
            "external_id" => "uvi",
            "name" => "UVI",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37145,
            "external_id" => "clouds",
            "name" => "Clouds",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37146,
            "external_id" => "visibility",
            "name" => "Visibility",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37147,
            "external_id" => "wind_speed",
            "name" => "Wind Speed",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37148,
            "external_id" => "wind_deg",
            "name" => "Wind Deg",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ],
        [
            "id" => 37149,
            "external_id" => "wind_gust",
            "name" => "Wind Gust",
            "type" => "float",
            "negative_ratio" => false,
            "options" => [
                "accumulator" => "sum"
            ]
        ]
    ];

    private ListMetricsService $listMetricsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->listMetricsService = $this->app->make('App\Services\Whatagraph\ListMetricsService');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_list_metrics_service()
    {
        Http::fake([
            self::URL => HTTP::response(['data' => self::METRICS])
        ]);
        $response = $this->listMetricsService->execute();
        $this->assertEquals(self::METRICS, $response['data']);
        $this->assertTrue(true);
    }

    public function test_failed_to_list_metrics()
    {
        Http::fake([
            self::URL => HTTP::response('', 500)
        ]);
        $this->expectException(WGException::class);
        $this->listMetricsService->execute();
    }
}

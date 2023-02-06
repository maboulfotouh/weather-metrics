<?php
namespace Tests\Unit\Services\Whatagraph;

use App\Exceptions\WGException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateMetricService extends TestCase
{
    use WithFaker;

    const URL = 'https://api.whatagraph.com/v1/integration-metrics/*';

    private CreateMetricService $createMetricService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createMetricService = $this->app->make('App\Services\Whatagraph\CreateMetricService');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_dimension_service()
    {
        Http::fake([
            self::URL => HTTP::response()
        ]);
        $this->createMetricService->execute('test', 'test', 'test');
        $this->assertTrue(true);
    }

    public function test_failed_to_create_dimension()
    {
        Http::fake([
            self::URL => HTTP::response('', 500)
        ]);
        $this->expectException(WGException::class);
        $this->createMetricService->execute('test', 'test', 'test');
    }
}

<?php
namespace App\Services\Whatagraph;

use App\Exceptions\WGException;
use App\Whatagraph\WGClient;

class ListMetricsService
{
    const ENDPOINT = '/v1/integration-metrics/';
    private WGClient $WGClient;

    public function __construct(WGClient $WGClient)
    {
        $this->WGClient = $WGClient;
    }

    /**
     * @return mixed
     * @throws WGException
     */
    public function execute(): mixed
    {
        return $this->WGClient->fire(self::ENDPOINT, 'GET', [
            'per_page' => 1000,
            'page' => 1
        ])->json();
    }
}

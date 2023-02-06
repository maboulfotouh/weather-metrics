<?php
namespace App\Services\Whatagraph;

use App\Exceptions\WGException;
use App\Whatagraph\WGClient;
use Illuminate\Support\Collection;

class CreateLocationSourceDataService
{
    const ENDPOINT = '/v1/integration-source-data/';
    private WGClient $WGClient;
    private array $metrics;

    public function __construct(WGClient $WGClient)
    {
        $this->WGClient = $WGClient;
        $this->metrics = config('whatagraph.metrics');
    }

    /**
     * @throws WGException
     * @param Collection $locations
     */
    public function execute(Collection $locations): void
    {
        $externalIDs = array_column($this->metrics, 'external_id');
        $data = [];
        $locations->each(function ($location) use ($externalIDs, &$data) {
            $locationData['city'] = "$location->name - $location->state - $location->country";
            $locationData['date'] = $location->locationWeatherData->dt->format('Y-m-d');
            foreach ($externalIDs as $externalID) {
                $locationData[$externalID] = $location->locationWeatherData->{$externalID};
            }
            $data[] = $locationData;
        });
        $this->WGClient->fire(self::ENDPOINT, 'POST', ['data' => $data])->json();
    }
}

<?php
namespace App\Adapters\Geocoding\OpenWeather;

use App\Adapters\OpenWeatherClient;
use App\Data\LocationData;
use App\Exceptions\OpenWeatherException;
use Spatie\LaravelData\DataCollection;

class SearchLocationsRequest extends OpenWeatherClient
{
    const ENDPOINT = '/geo/1.0/direct';
    private string $query;
    private int $limit;

    public function __construct(string $query, int $limit = 5)
    {
        parent::__construct();
        $this->query = $query;
        $this->limit = $limit;
    }

    /**
     * @throws OpenWeatherException
     */
    public function locationsDTO(): DataCollection
    {
        $URL = $this->urlBuilder(self::ENDPOINT, [
            'q' => $this->query,
            'limit' => $this->limit
        ]);
        $response = $this->fire($URL)->json();

        return LocationData::collection($response);
    }
}

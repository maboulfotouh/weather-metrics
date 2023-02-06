<?php
namespace App\Adapters\Geocoding;

use App\Adapters\Geocoding\Contracts\GeocodingAdapterInterface;
use App\Adapters\Geocoding\OpenWeather\SearchLocationsRequest;
use App\Exceptions\OpenWeatherException;
use Spatie\LaravelData\DataCollection;

class OpenWeatherGeocodingAdapter implements GeocodingAdapterInterface
{
    /**
     * @param string $query
     * @param ?int $limit
     * @return DataCollection
     * @throws OpenWeatherException
     */
    public function searchLocation(string $query, ?int $limit = 5): DataCollection
    {
        return (new SearchLocationsRequest($query, $limit))->locationsDTO();
    }
}

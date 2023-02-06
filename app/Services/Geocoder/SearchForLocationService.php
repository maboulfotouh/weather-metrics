<?php
namespace App\Services\Geocoder;

use App\Adapters\Geocoding\Contracts\GeocodingAdapterInterface;
use Spatie\LaravelData\DataCollection;

class SearchForLocationService
{
    private GeocodingAdapterInterface $geocodingAdapter;

    public function __construct(GeocodingAdapterInterface $geocodingAdapter)
    {
        $this->geocodingAdapter = $geocodingAdapter;
    }

    public function execute(string $query): DataCollection
    {
        return $this->geocodingAdapter->searchLocation($query);
    }
}

<?php
namespace App\Adapters\Geocoding\Contracts;

use Spatie\LaravelData\DataCollection;

interface GeocodingAdapterInterface
{
    public function searchLocation(string $query, ?int $limit = 5): DataCollection;
}

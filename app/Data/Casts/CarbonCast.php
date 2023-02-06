<?php
namespace App\Data\Casts;

use Carbon\Carbon;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CarbonCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): Carbon
    {
        return Carbon::createFromTimestamp($value, config('app.timezone'));
    }
}

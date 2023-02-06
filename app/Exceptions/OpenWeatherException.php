<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Request;
use Response;

class OpenWeatherException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return Response::json(['message' => 'Request failed to OpenWeather APIs'], 500);
    }
}

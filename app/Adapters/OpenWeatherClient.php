<?php
namespace App\Adapters;

use App\Exceptions\OpenWeatherException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class OpenWeatherClient
{
    private string $baseURL;

    private string $apiKey;

    public function __construct()
    {
        $this->baseURL = config('openweather.base_url');
        $this->apiKey = config('openweather.api_key');
    }

    protected function urlBuilder(string $endpoint, array $fields = []): string
    {
        $fields['appid'] = $this->apiKey;

        return "{$this->baseURL}{$endpoint}?" . http_build_query($fields);
    }

    /**
     * @param string $url
     * @return Response
     * @throws OpenWeatherException
     */
    protected function fire(string $url): Response
    {
        try {
            return Http::get($url)->throw();
        } catch (Throwable $exception) {
            report($exception);

            throw new OpenWeatherException();
        }
    }
}

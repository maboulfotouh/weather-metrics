<?php
namespace App\Whatagraph;

use App\Exceptions\WGException;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

final class WGClient
{
    private string $accessToken;
    private string $baseURL;

    public function __construct()
    {
        $this->accessToken = config('whatagraph.access_token');
        $this->baseURL = config('whatagraph.base_url');
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $payload
     * @return Response
     * @throws WGException
     */
    public function fire(string $endpoint, string $method, array $payload): Response
    {
        $http = Http::withHeaders($this->headers());
        $url = $this->baseURL . $endpoint;

        try {
            return match (strtolower($method)) {
                'post' => $http->post($url, $payload),
                'get' => $http->get($url, $payload),
                'put' => $http->put($url, $payload),
                'patch' => $http->patch($url, $payload),
                'delete' => $http->delete($url, $payload),
                default => throw new InvalidArgumentException('Invalid method name'),
            };
        } catch (Throwable $exception) {
            report($exception);

            throw new WGException('Request failed to Whatagraph APIs');
        }
    }

    private function headers(): array
    {
        return [
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => "Bearer $this->accessToken"
        ];
    }
}

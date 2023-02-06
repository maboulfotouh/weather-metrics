<?php
namespace App\Services\Whatagraph;

use App\Exceptions\WGException;
use App\Whatagraph\WGClient;

class CreateDimensionService
{
    const ENDPOINT = '/v1/integration-dimensions/';
    private WGClient $WGClient;

    public function __construct(WGClient $WGClient)
    {
        $this->WGClient = $WGClient;
    }

    /**
     * @throws WGException
     * @param string $name
     * @param string $externalID
     * @param string $type
     */
    public function execute(string $name, string $externalID, string $type): void
    {
        $this->WGClient->fire(self::ENDPOINT, 'POST', [
            'name' => $name,
            'external_id' => $externalID,
            'type' => $type,
        ]);
    }
}

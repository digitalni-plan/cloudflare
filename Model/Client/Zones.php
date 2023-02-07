<?php
/**
 * @dplan_header_copyright
 * @package     digitalni-plan/cloudflare
 * @copyright   Copyright (c) 2023. Digitalni plan d.o.o.
 * @author      Neven Kajić <neven.kajic@digitalniplan.com>, <nkajic@gmail.com>
 */

namespace DPlan\CloudFlare\Model\Client;

use Cloudflare\API\Adapter\Guzzle;
use Cloudflare\API\Auth\APIToken;
use Cloudflare\API\Endpoints\EndpointException;
use Cloudflare\API\Endpoints\Zones as CloudflareZones;
use DPlan\CloudFlare\Config\API as APIConfig;

class Zones
{
    private APIConfig $apiConfig;

    private CloudflareZones $client;

    public function __construct(
        APIConfig $apiConfig
    ) {
        $this->apiConfig = $apiConfig;

        $key     = new APIToken($this->getApiToken());
        $adapter = new Guzzle($key);
        $this->client = new CloudflareZones($adapter);
    }

    protected function getApiToken(): string
    {
        return $this->apiConfig->getToken();
    }

    protected function getApiZoneId(): string
    {
        return $this->apiConfig->getZoneId();
    }

    /**
     * @throws EndpointException
     */
    public function cachePurgeFiles(array $urls): bool {
        return $this->client->cachePurge($this->getApiZoneId(), $urls);
    }
}

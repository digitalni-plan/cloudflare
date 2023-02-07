<?php
/**
 * @dplan_header_copyright
 * @package     digitalni-plan/cloudflare
 * @copyright   Copyright (c) 2023. Digitalni plan d.o.o.
 * @author      Neven Kajić <neven.kajic@digitalniplan.com>, <nkajic@gmail.com>
 */

namespace DPlan\CloudFlare\Plugin\DPlan\Sync\Product;

use Cloudflare\API\Endpoints\EndpointException;
use DPlan\CloudFlare\Model\Client\Zones as ClientZones;
use DPlan\Sync\Model\Destination\Entity\Product\ImageVariants as OriginalImageVariants;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use DPlan\CloudFlare\Config\General as ConfigGeneral;

class ImageVariants
{
    private ConfigGeneral $configGeneral;
    private StoreManagerInterface $storeManager;
    private ClientZones $clientZones;

    public function __construct(
        ConfigGeneral $configGeneral,
        StoreManagerInterface $storeManager,
        ClientZones $zones
    ) {
        $this->configGeneral = $configGeneral;
        $this->storeManager = $storeManager;
        $this->clientZones = $zones;
    }

    /**
     * @param OriginalImageVariants $subject
     * @param array $result
     * @param $imageFile
     * @return array
     * @throws EndpointException
     */
    public function afterDeleteSourceAndImageVariants(OriginalImageVariants $subject, array $result, $imageFile): array
    {
        // Module is disabled. Skip.
        if (!$this->configGeneral->isEnabled()) {
            return $result;
        }

        $urls = [];
        foreach ($result as $image) {
            $urls[] = $this->storeManager->getDefaultStoreView()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $image;
        }

//        echo "CloudFlare Purge success: " . $this->clientZones->cachePurgeFiles($urls) ? 'Success' : 'Failed' . PHP_EOL;
        $this->clientZones->cachePurgeFiles($urls);
        return $result;
    }
}

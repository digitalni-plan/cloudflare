<?php
/**
 * @dplan_header_copyright
 * @package     digitalni-plan/cloudflare
 * @copyright   Copyright (c) 2023. Digitalni plan d.o.o.
 * @author      Neven Kajić <neven.kajic@digitalniplan.com>, <nkajic@gmail.com>
 */

namespace DPlan\CloudFlare\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class General
{
    const XML_PATH_PREFIX = 'dplan_cloudflare/general/';

    private ScopeConfigInterface $scopeConfig;
    private StoreManagerInterface $storeManager;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getValue($key, $scopeType = ScopeInterface::SCOPE_STORE) {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PREFIX . $key,
            $scopeType
        );
    }

    public function isEnabled(): bool {
        return (bool) $this->getValue('enabled');
    }
}

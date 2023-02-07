<?php
/**
 * @dplan_header_copyright
 * @package     digitalni-plan/cloudflare
 * @copyright   Copyright (c) 2023. Digitalni plan d.o.o.
 * @author      Neven Kajić <neven.kajic@digitalniplan.com>, <nkajic@gmail.com>
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'DPlan_CloudFlare',
    __DIR__
);

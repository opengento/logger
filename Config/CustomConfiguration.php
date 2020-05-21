<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class CustomConfiguration
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Json
     */
    private $serializer;

    public function __construct(ScopeConfigInterface $scopeConfig, Json $serializer)
    {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    public function getUnserializedConfigValue(string $configPath, ?string $store = null): ?array
    {
        $value = $this->getConfigValue($configPath, $store);

        if (!$value) {
            return null;
        }

        return $this->serializer->unserialize($value);
    }

    public function getConfigValue(string $configPath, ?string $store = null)
    {
        return $this->scopeConfig->getValue($configPath, ScopeInterface::SCOPE_STORE, $store);
    }
}

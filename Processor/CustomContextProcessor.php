<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Processor;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;
use Monolog\Processor\ProcessorInterface;

class CustomContextProcessor implements ProcessorInterface
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

    public function __invoke(array $records): array
    {
        foreach ($this->resolveTypesLogger() as $value) {
            $records['context'][$value['custom_logger_key']] = $value['custom_logger_value'];
        }

        return $records;
    }

    private function resolveTypesLogger(?string $store = null): array
    {
        return $this->serializer->unserialize(
            $this->scopeConfig->getValue('loggin/context/types_logger', ScopeInterface::SCOPE_STORE, $store) ?: '{}'
        );
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Gelf\PublisherInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\GelfHandler as MonologGelfHandler;
use Monolog\Handler\HandlerInterface;

class GelfHandler implements MagentoHandlerInterface
{
    public function __construct(
        private PublisherInterface $publisher,
        private ScopeConfigInterface $scopeConfig,
        private string $isEnabled,
        private string $levelPath
    ) {
    }

    public function getInstance(): HandlerInterface
    {
        return new MonologGelfHandler(
            $this->publisher,
            $this->scopeConfig->getValue($this->levelPath)
        );
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

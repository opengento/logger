<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;

class ConsoleHandler implements MagentoHandlerInterface
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private string $isEnabled,
        private string $levelPath
    ) {
    }

    /**
     * @throws Exception
     */
    public function getInstance(): HandlerInterface
    {
        return new StreamHandler('php://stdout', $this->scopeConfig->getValue($this->levelPath));
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

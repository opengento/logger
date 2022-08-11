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
    /**
     * @var string
     */
    private $isEnabled;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string
     */
    private $levelPath;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $levelPath
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
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

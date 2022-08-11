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
    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * @var string
     */
    private $isEnabled;

    /**
     * @var string
     */
    private $levelPath;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        PublisherInterface $publisher,
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $levelPath
    ) {
        $this->publisher = $publisher;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
        $this->scopeConfig = $scopeConfig;
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

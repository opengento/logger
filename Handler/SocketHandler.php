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
use Monolog\Handler\SocketHandler as MonologSocketHandler;
use Monolog\Formatter\JsonFormatter;

class SocketHandler implements MagentoHandlerInterface
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

    /**
     * @var string
     */
    private $endpoint;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $levelPath,
        string $endpoint
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
        $this->endpoint = $endpoint;
    }

    /**
     * @throws Exception
     */
    public function getInstance(): HandlerInterface
    {
        $handler = new MonologSocketHandler(
            $this->scopeConfig->getValue($this->endpoint),
            $this->scopeConfig->getValue($this->levelPath)
        );
        $handler->setFormatter(new JsonFormatter(JsonFormatter::BATCH_MODE_NEWLINES));

        return $handler;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

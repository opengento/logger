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
use RuntimeException;

class SocketHandler implements MagentoHandlerInterface
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private string $isEnabled,
        private string $levelPath,
        private string $endpoint
    ) {
    }

    /**
     * @throws RuntimeException
     */
    public function getInstance(): HandlerInterface
    {
        $endpointUrl = trim((string) $this->scopeConfig->getValue($this->endpoint));
        if ($endpointUrl === '') {
            throw new RuntimeException(sprintf(
                'Config key "%s" is missing or empty.',
                $this->endpoint
            ));
        }

        $handler = new MonologSocketHandler($endpointUrl, $this->scopeConfig->getValue($this->levelPath));
        $handler->setFormatter(new JsonFormatter(JsonFormatter::BATCH_MODE_NEWLINES));

        return $handler;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

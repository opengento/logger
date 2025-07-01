<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\NativeMailerHandler;

class MailHandler implements MagentoHandlerInterface
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private string $isEnabled,
        private string $toPath,
        private string $subjectPath,
        private string $fromPath,
        private string $levelPath
    ) {
    }

    public function getInstance(): HandlerInterface
    {
        return new NativeMailerHandler(
            $this->scopeConfig->getValue($this->toPath),
            $this->scopeConfig->getValue($this->subjectPath),
            $this->scopeConfig->getValue($this->fromPath),
            $this->scopeConfig->getValue($this->levelPath)
        );
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

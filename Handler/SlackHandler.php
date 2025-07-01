<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\SlackHandler as MonologSlackHandler;

class SlackHandler implements MagentoHandlerInterface
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private string $isEnabled,
        private string $levelPath,
        private string $tokenPath,
        private string $channelPath,
        private string $usernamePath,
        private string $useAttachmentPath,
        private string $iconEmojiPath,
        private string $bubblePath,
        private string $useShortAttachmentPath,
        private string $includeContextAndExtraPath
    ) {
    }

    /**
     * @throws MissingExtensionException
     */
    public function getInstance(): HandlerInterface
    {
        return new MonologSlackHandler(
            $this->scopeConfig->getValue($this->tokenPath),
            $this->scopeConfig->getValue($this->channelPath),
            $this->scopeConfig->getValue($this->usernamePath),
            $this->scopeConfig->isSetFlag($this->useAttachmentPath),
            $this->scopeConfig->getValue($this->iconEmojiPath),
            $this->scopeConfig->getValue($this->levelPath),
            $this->scopeConfig->isSetFlag($this->bubblePath),
            $this->scopeConfig->isSetFlag($this->useShortAttachmentPath),
            $this->scopeConfig->isSetFlag($this->includeContextAndExtraPath)
        );
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

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
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string
     */
    private $isEnabled;

    /**
     * @var string
     */
    private $levelPath;

    /**
     * @var string
     */
    private $tokenPath;

    /**
     * @var string
     */
    private $channelPath;

    /**
     * @var string
     */
    private $usernamePath;

    /**
     * @var string
     */
    private $useAttachmentPath;

    /**
     * @var string
     */
    private $iconEmojiPath;

    /**
     * @var string
     */
    private $bubblePath;

    /**
     * @var string
     */
    private $useShortAttachmentPath;

    /**
     * @var string
     */
    private $includeContextAndExtraPath;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $levelPath,
        string $tokenPath,
        string $channelPath,
        string $usernamePath,
        string $useAttachmentPath,
        string $iconEmojiPath,
        string $bubblePath,
        string $useShortAttachmentPath,
        string $includeContextAndExtraPath
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
        $this->tokenPath = $tokenPath;
        $this->channelPath = $channelPath;
        $this->usernamePath = $usernamePath;
        $this->useAttachmentPath = $useAttachmentPath;
        $this->iconEmojiPath = $iconEmojiPath;
        $this->bubblePath = $bubblePath;
        $this->useShortAttachmentPath = $useShortAttachmentPath;
        $this->includeContextAndExtraPath = $includeContextAndExtraPath;
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
            $this->scopeConfig->getValue($this->useAttachmentPath),
            $this->scopeConfig->getValue($this->iconEmojiPath),
            $this->scopeConfig->getValue($this->levelPath),
            $this->scopeConfig->getValue($this->bubblePath),
            $this->scopeConfig->getValue($this->useShortAttachmentPath),
            $this->scopeConfig->getValue($this->includeContextAndExtraPath)
        );
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

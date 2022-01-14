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
    private $toPath;

    /**
     * @var string
     */
    private $subjectPath;

    /**
     * @var string
     */
    private $fromPath;

    /**
     * @var string
     */
    private $levelPath;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $toPath,
        string $subjectPath,
        string $fromPath,
        string $levelPath
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->toPath = $toPath;
        $this->subjectPath = $subjectPath;
        $this->fromPath = $fromPath;
        $this->levelPath = $levelPath;
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
        return (bool)$this->scopeConfig->getValue($this->isEnabled);
    }
}

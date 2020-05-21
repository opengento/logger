<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\NativeMailerHandler;
use Opengento\Logger\Traits\VerifyConfiguration;

/**
 * This wrapper is useful to add the "PublisherInterface" type in the constructor
 * and allow the DI to generate this handler.
 *
 * @package Opengento\Logger\Handler
 */
class MailHandlerWrapper extends NativeMailerHandler
{
    use VerifyConfiguration;

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
     * @var NativeMailerHandler
     */
    private $nativeMailHandler;

    /**
     * MailHandlerWrapper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param string $isEnabled
     * @param string $toPath
     * @param string $subjectPath
     * @param string $fromPath
     * @param string $levelPath
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $toPath,
        string $subjectPath,
        string $fromPath,
        string $levelPath
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->toPath = $toPath;
        $this->subjectPath = $subjectPath;
        $this->fromPath = $fromPath;
        $this->levelPath = $levelPath;
    }

    /**
     * @return NativeMailerHandler
     */
    final public function getInstance()
    {
        if (!$this->nativeMailHandler) {
            $this->nativeMailHandler = new NativeMailerHandler(
                $this->scopeConfig->getValue($this->toPath),
                $this->scopeConfig->getValue($this->subjectPath),
                $this->scopeConfig->getValue($this->fromPath),
                $this->scopeConfig->getValue($this->levelPath)
            );
        }

        return $this->nativeMailHandler;
    }
}

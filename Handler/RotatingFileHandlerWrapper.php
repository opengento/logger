<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\RotatingFileHandler;
use Opengento\Logger\Traits\VerifyConfiguration;

/**
 * This wrapper is useful to add the "PublisherInterface" type in the constructor
 * and allow the DI to generate this handler.
 *
 * @package Opengento\Logger\Handler
 */
class RotatingFileHandlerWrapper extends RotatingFileHandler
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
     * @var RotatingFileHandler
     */
    private $rotatingFileHandler;

    /**
     * @var string
     */
    private $filenamePath;

    /**
     * @var string
     */
    private $maxFilesPath;

    /**
     * RotatingFileHandlerWrapper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param string $isEnabled
     * @param string $levelPath
     * @param string $filenamePath
     * @param string $maxFilesPath
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $levelPath,
        string $filenamePath,
        string $maxFilesPath
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
        $this->filenamePath = $filenamePath;
        $this->maxFilesPath = $maxFilesPath;
    }

    /**
     * @return RotatingFileHandler
     * @throws \Exception
     */
    final public function getInstance(): RotatingFileHandler
    {
        if (!$this->rotatingFileHandler) {
            $this->rotatingFileHandler = new RotatingFileHandler(
                __DIR__ . '/../../../../var/log/' . $this->scopeConfig->getValue($this->filenamePath),
                $this->scopeConfig->getValue($this->maxFilesPath),
                $this->scopeConfig->getValue($this->levelPath)
            );
        }

        return $this->rotatingFileHandler;
    }
}

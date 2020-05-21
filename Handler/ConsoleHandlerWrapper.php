<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types = 1);

namespace Opengento\Logger\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Opengento\Logger\Traits\VerifyConfiguration;

/**
 * This wrapper is useful to add the "PublisherInterface" type in the constructor
 * and allow the DI to generate this handler.
 *
 * @package Opengento\Logger\Handler
 */
class ConsoleHandlerWrapper extends StreamHandler
{
    use VerifyConfiguration;

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
     * @var StreamHandler
     */
    private $consoleHandler;

    /**
     * ConsoleHandlerWrapper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param string $isEnabled
     * @param string $levelPath
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $isEnabled,
        string $levelPath
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
    }

    /**
     * @return StreamHandler
     * @throws \Exception
     */
    final public function getInstance(): StreamHandler
    {
        if (!$this->consoleHandler) {
            $this->consoleHandler = new StreamHandler(
                'php://stdout',
                $this->scopeConfig->getValue($this->levelPath)
            );
        }

        return $this->consoleHandler;
    }
}

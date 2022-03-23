<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem\DirectoryList;
use Monolog\Handler\HandlerInterface;

class RotatingFileHandler implements MagentoHandlerInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var DirectoryList
     */
    private $directoryList;

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
    private $filenamePath;

    /**
     * @var string
     */
    private $maxFilesPath;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        DirectoryList $directoryList,
        string $isEnabled,
        string $levelPath,
        string $filenamePath,
        string $maxFilesPath
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->directoryList = $directoryList;
        $this->isEnabled = $isEnabled;
        $this->levelPath = $levelPath;
        $this->filenamePath = $filenamePath;
        $this->maxFilesPath = $maxFilesPath;
    }

    /**
     * @throws Exception
     */
    public function getInstance(): HandlerInterface
    {
        return new \Monolog\Handler\RotatingFileHandler(
            sprintf(
                '%s/log/%s',
                $this->directoryList->getPath(DirectoryList::VAR_DIR),
                $this->scopeConfig->getValue($this->filenamePath)
            ),
            $this->scopeConfig->getValue($this->maxFilesPath),
            $this->scopeConfig->getValue($this->levelPath)
        );
    }

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue($this->isEnabled);
    }
}
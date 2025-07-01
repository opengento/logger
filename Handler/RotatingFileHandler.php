<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Monolog\Handler\HandlerInterface;

class RotatingFileHandler implements MagentoHandlerInterface
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private DirectoryList $directoryList,
        private string $isEnabled,
        private string $levelPath,
        private string $filenamePath,
        private string $maxFilesPath
    ) {
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
            (int) $this->scopeConfig->getValue($this->maxFilesPath),
            $this->scopeConfig->getValue($this->levelPath)
        );
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

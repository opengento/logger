<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Elasticsearch\ClientBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Handler\ElasticsearchHandler as MonologElasticsearchHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\NoopHandler;
use RuntimeException;

class ElasticsearchHandler implements MagentoHandlerInterface
{
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly string               $isEnabled,
        private readonly string               $levelPath,
        private readonly string               $hostPath,
        private readonly string               $indexPath,
        private readonly string               $isAuthenticationEnabledPath,
        private readonly string               $usernamePath,
        private readonly string               $passwordPath,
        private readonly string               $ignoreErrorPath,
    )
    {
    }

    public function getInstance(): HandlerInterface
    {
        $client = ClientBuilder::create()->setHosts(
            [$this->scopeConfig->getValue($this->hostPath)]
        );

        if ($this->scopeConfig->isSetFlag($this->isAuthenticationEnabledPath)) {
            if (
                $this->scopeConfig->getValue($this->usernamePath) === null ||
                $this->scopeConfig->getValue($this->passwordPath) === null
            ) {
                if ($this->scopeConfig->isSetFlag($this->ignoreErrorPath)) {
                    return new NoopHandler();
                }

                throw new RuntimeException('Elasticsearch authentication is enabled but no credentials are provided.');
            }

            $client = $client->setBasicAuthentication(
                $this->scopeConfig->getValue($this->usernamePath),
                $this->scopeConfig->getValue($this->passwordPath)
            );
        }

        return new MonologElasticsearchHandler(
            $client->build(),
            [
                'index' => $this->scopeConfig->getValue($this->indexPath),
                'ignore_error' => $this->scopeConfig->isSetFlag($this->ignoreErrorPath)
            ],
            $this->scopeConfig->getValue($this->levelPath)
        );
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag($this->isEnabled);
    }
}

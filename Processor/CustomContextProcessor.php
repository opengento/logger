<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Processor;

use Monolog\Processor\ProcessorInterface;
use Opengento\Logger\Config\Config;
use Opengento\Logger\Config\CustomConfiguration;

class CustomContextProcessor implements ProcessorInterface
{
    /**
     * @var CustomConfiguration
     */
    private $customConfiguration;

    public function __construct(CustomConfiguration $customConfiguration)
    {
        $this->customConfiguration = $customConfiguration;
    }

    public function __invoke(array $records): array
    {
        $customConfiguration = $this->customConfiguration->getUnserializedConfigValue(Config::CONFIG_LOGGER_CUSTOM_CONFIGURATION);

        if (!$customConfiguration) {
            return $records;
        }

        foreach ($customConfiguration as $value) {
            $records['context'][$value['custom_logger_key']] = $value['custom_logger_value'];
        }

        return $records;
    }
}

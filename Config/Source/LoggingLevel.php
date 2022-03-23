<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Monolog\Logger;

class LoggingLevel implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => Logger::DEBUG, 'label' => __('Debug')],
            ['value' => Logger::INFO, 'label' => __('Info')],
            ['value' => Logger::NOTICE, 'label' => __('Notice')],
            ['value' => Logger::WARNING, 'label' => __('Warning')],
            ['value' => Logger::ERROR, 'label' => __('Error')],
            ['value' => Logger::CRITICAL, 'label' => __('Critical')],
            ['value' => Logger::ALERT, 'label' => __('Alert')],
            ['value' => Logger::EMERGENCY, 'label' => __('Emergency')],
        ];
    }
}

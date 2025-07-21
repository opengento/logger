<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class ExceptionProcessor implements ProcessorInterface
{
    /**
     * LogRecord is used for Monolog 3.x (Magento >= 2.4.8)
     * Array is used for Monolog 2.x (Magento <= 2.4.7)
     */
    public function __invoke(LogRecord|array $records): LogRecord|array
    {
        if (isset($records['context']['exception'])) {
            $records['extra']['stacktrace'] = $records['context']['exception']->getTraceAsString();
        }

        return $records;
    }
}

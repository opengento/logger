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
    public function __invoke(LogRecord $records): LogRecord
    {
        if (isset($records['context']['exception'])) {
            $records['extra']['stacktrace'] = $records['context']['exception']->getTraceAsString();
        }

        return $records;
    }
}

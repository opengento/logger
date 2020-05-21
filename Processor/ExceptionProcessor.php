<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Processor;

use Monolog\Processor\ProcessorInterface;

/**
 * Class ExceptionProcessor
 *
 * @package Opengento\Logger\Processor
 */
class ExceptionProcessor implements ProcessorInterface
{
    /**
     * @param array $records
     * @return array The processed records
     */
    public function __invoke(array $records)
    {
        if (isset($records['context']['exception'])) {
            $records['extra']['stacktrace'] = $records['context']['exception']->getTraceAsString();
        }

        return $records;
    }
}

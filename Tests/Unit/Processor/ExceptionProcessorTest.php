<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

namespace Opengento\Logger\Tests\Unit\Processor;

use Opengento\Logger\Processor\ExceptionProcessor;
use PHPUnit\Framework\TestCase;

/**
 * Tests the exception processor.
 *
 * @package Opengento\Logger\Tests\Unit\Processor
 */
class ExceptionProcessorTest extends TestCase
{
    /**
     * Tests invoke processor add extra information.
     */
    public function testInvokeAddExtraInformationIntoRecords(): void
    {
        $records = ['extra' => [], 'context' => ['exception' => new \LogicException('Test')]];

        $processor = new ExceptionProcessor();
        $records = $processor($records);

        $this->assertArrayHasKey('stacktrace', $records['extra']);
    }

    /**
     * Tests invoke processor without exception doesn't add extra information.
     */
    public function testInvokeWithoutAddExtraInformationIntoRecords(): void
    {
        $records = ['extra' => []];

        $processor = new ExceptionProcessor();
        $records = $processor($records);

        $this->assertArrayNotHasKey('stacktrace', $records['extra']);
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

namespace Opengento\Logger\Tests\Unit\Processor;

use Opengento\Logger\Config\CustomConfiguration;
use Opengento\Logger\Processor\CustomContextProcessor;
use PHPUnit\Framework\TestCase;

class CustomContextProcessorTest extends TestCase
{
    /**
     * Tests invoke processor add context information.
     */
    public function testInvokeAddContextInformationIntoRecords(): void
    {
        $records = ['context' => []];
        $customConfigurationStub = $this->createMock(CustomConfiguration::class);
        $customConfigurationStub
            ->method('getUnserializedConfigValue')
            ->willReturn(['env' => 'test']);

        $processor = new CustomContextProcessor($customConfigurationStub);
        $records = $processor($records);

        $this->assertArrayHasKey('env', $records['context']);
    }

    /**
     * Tests invoke processor without anything in custom context array
     */
    public function testInvokeWithoutAddContextInformationIntoRecords(): void
    {
        $records = ['context' => []];

        $customConfigurationStub = $this->createMock(CustomConfiguration::class);
        $customConfigurationStub
            ->method('getUnserializedConfigValue')
            ->willReturn(null);

        $processor = new CustomContextProcessor($customConfigurationStub);
        $records = $processor($records);

        $this->assertArrayNotHasKey('env', $records['context']);
    }
}

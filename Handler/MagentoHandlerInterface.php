<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Handler;

use Monolog\Handler\HandlerInterface;

interface MagentoHandlerInterface
{
    public function getInstance(): HandlerInterface;

    public function isEnabled(): bool;
}

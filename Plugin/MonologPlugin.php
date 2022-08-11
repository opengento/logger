<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Plugin;

use Magento\Framework\Logger\Monolog;
use Monolog\Handler\HandlerInterface;
use Opengento\Logger\Handler\MagentoHandlerInterface;

class MonologPlugin
{
    public function aroundSetHandlers(Monolog $subject, callable $proceed, array $handlers): void
    {
        $magentoHandlers = [];
        foreach ($handlers as $handler) {
            if ($handler instanceof MagentoHandlerInterface && $handler->isEnabled()) {
                $magentoHandlers[] = $handler->getInstance();
            } elseif ($handler instanceof HandlerInterface) {
                $magentoHandlers[] = $handler;
            }
        }

        $proceed($magentoHandlers);
    }
}

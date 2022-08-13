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
    public function beforeSetHandlers(Monolog $subject, array $handlers): array
    {
        $magentoHandlers = [];
        foreach ($handlers as $key => $handler) {
            if ($handler instanceof MagentoHandlerInterface && $handler->isEnabled()) {
                $magentoHandlers[$key] = $handler->getInstance();
            } elseif ($handler instanceof HandlerInterface) {
                $magentoHandlers[$key] = $handler;
            }
        }

        return [$magentoHandlers];
    }
}

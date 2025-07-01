<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Plugin;

use Monolog\Logger;
use Opengento\Logger\Handler\MagentoHandlerInterface;

class MonologPlugin
{
    /**
     * @param  MagentoHandlerInterface[]  $magentoHandlers
     */
    public function __construct(private array $magentoHandlers)
    {
    }

    /**
     * @param  Logger  $subject
     * @param  array  $handlers
     * @return array
     */
    public function beforeSetHandlers(Logger $subject, array $handlers): array
    {
        foreach ($this->magentoHandlers as $handler) {
            if ($handler->isEnabled()) {
                array_unshift($handlers, $handler->getInstance());
            }
        }

        return [$handlers];
    }
}

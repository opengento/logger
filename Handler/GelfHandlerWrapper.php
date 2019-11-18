<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

namespace Opengento\Logger\Handler;

use Gelf\PublisherInterface;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;

/**
 * This wrapper is useful to add the "PublisherInterface" type in the constructor
 * and allow the DI to generate this handler.
 *
 * @package Opengento\Logger\Handler
 */
class GelfHandlerWrapper extends GelfHandler
{
    /**
     * GelfHandlerWrapper constructor.
     *
     * @param PublisherInterface $publisher
     * @param int                $level
     * @param bool               $bubble
     */
    public function __construct(PublisherInterface $publisher, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($publisher, $level, $bubble);
    }
}

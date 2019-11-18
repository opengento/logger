<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
namespace Opengento\Logger\Publisher;

use Gelf\MessageInterface;
use Gelf\PublisherInterface;

/**
 * Class GelfPublisherWrapper
 *
 * @package Opengento\Logger\Publisher
 */
class GelfPublisherWrapper implements PublisherInterface
{
    /**
     * @var PublisherInterface
     */
    private $publisher;

    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Publish a message
     *
     * @param MessageInterface $message
     *
     * @return void
     */
    public function publish(MessageInterface $message)
    {
        return $this->publisher->publish($message);
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

namespace Opengento\Logger\Publisher;

use Gelf\MessageInterface;
use Gelf\PublisherInterface;
use Opengento\Logger\Config\CustomConfiguration;
use Opengento\Logger\Config\Config;

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

    /**
     * @var CustomConfiguration
     */
    private $customConfiguration;

    /**
     * GelfPublisherWrapper constructor.
     * @param PublisherInterface $publisher
     * @param CustomConfiguration $customConfiguration
     */
    public function __construct(PublisherInterface $publisher, CustomConfiguration $customConfiguration)
    {
        $this->customConfiguration = $customConfiguration;
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
        $this->joinCustomConfiguration($message);

        return $this->publisher->publish($message);
    }

    /**
     * @param MessageInterface $message
     */
    public function joinCustomConfiguration(MessageInterface $message)
    {
        $customConfiguration = $this->customConfiguration->getUnserializedConfigValue(Config::CONFIG_LOGGER_CUSTOM_CONFIGURATION);

        if(!$customConfiguration) return;

        foreach ($customConfiguration as $value) {
            $message->setAdditional($value['custom_logger_key'], $value['custom_logger_value']);
        }
    }
}

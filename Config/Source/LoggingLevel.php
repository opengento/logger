<?php

namespace Opengento\Logger\Config\Source;

class LoggingLevel implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * @return array|array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => \Monolog\Logger::DEBUG, 'label' => __('Debug')],
            ['value' => \Monolog\Logger::INFO, 'label' => __('Info')],
            ['value' => \Monolog\Logger::NOTICE, 'label' => __('Notice')],
            ['value' => \Monolog\Logger::WARNING, 'label' => __('Warning')],
            ['value' => \Monolog\Logger::ERROR, 'label' => __('Error')],
            ['value' => \Monolog\Logger::CRITICAL, 'label' => __('Critical')],
            ['value' => \Monolog\Logger::ALERT, 'label' => __('Alert')],
            ['value' => \Monolog\Logger::EMERGENCY, 'label' => __('Emergency')],
        ];
    }
}

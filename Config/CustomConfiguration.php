<?php

namespace Opengento\Logger\Config;

/**
 * Class CustomConfiguration
 */
class CustomConfiguration
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $serializer;


    /**
     * CustomFields constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Serialize\Serializer\Json $serializer
     */
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Serialize\Serializer\Json $serializer)
    {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @param $configPath
     * @param null $store
     * @return mixed
     */
    public function getConfigValue($configPath, $store = null){
        return $this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param $configPath
     * @param null $store
     * @return array|bool|float|int|mixed|string|null
     */
    public function getUnserializedConfigValue($configPath, $store = null){
        $value = $this->getConfigValue($configPath, $store);

        if(!$value) return false;

        return $this->serializer->unserialize($value);
    }
}
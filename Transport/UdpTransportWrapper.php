<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Transport;

use Gelf\MessageInterface as Message;
use Gelf\Transport\TransportInterface;
use Gelf\Transport\UdpTransport;
use Gelf\Transport\UdpTransportFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

use in_array;

/**
 * Class UdpTransportWrapper
 *
 * @package Opengento\Logger\Transport
 */
class UdpTransportWrapper implements TransportInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string
     */
    private $hostPath;

    /**
     * @var string
     */
    private $portPath;

    /**
     * @var string
     */
    private $chunkSize;

    /**
     * @var UdpTransport
     */
    private $transporter;

    /**
     * @var UdpTransportFactory
     */
    private $transportFactory;

    /**
     * @var string[] $blacklistedMessages
     */
    private $blacklistedMessages;

    public function __construct(
        UdpTransportFactory $transportFactory,
        ScopeConfigInterface $scopeConfig,
        string $hostPath,
        string $portPath,
        string $chunkSize = UdpTransport::CHUNK_SIZE_LAN,
        array $blacklistedMessages = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->hostPath = $hostPath;
        $this->portPath = $portPath;
        $this->chunkSize = $chunkSize;
        $this->transportFactory = $transportFactory;
        $this->blacklistedMessages = $blacklistedMessages;
    }

    /**
     * Sends a Message over this transport.
     *
     * @param Message $message
     *
     * @return int the number of bytes sent
     */
    public function send(Message $message): int
    {
        if (in_array($message->getShortMessage(), $this->blacklistedMessages, true)) {
            return 0;
        }

        return $this->getTransporter()->send($message);
    }

    /**
     * @return UdpTransport
     */
    private function getTransporter(): UdpTransport
    {
        if (null === $this->transporter) {
            $this->transporter = $this->transportFactory->create([
                'host'      => $this->scopeConfig->getValue($this->hostPath),
                'port'      => $this->scopeConfig->getValue($this->portPath),
                'chunkSize' => $this->chunkSize
            ]);
        }

        return $this->transporter;
    }
}

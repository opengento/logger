<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Transport;

use Exception;
use Gelf\MessageInterface as Message;
use Gelf\Transport\TransportInterface;
use Gelf\Transport\UdpTransport;
use Gelf\Transport\UdpTransportFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

use function in_array;

/**
 * Class UdpTransportWrapper
 *
 * @package Opengento\Logger\Transport
 */
class UdpTransportWrapper implements TransportInterface
{
    /**
     * @var UdpTransportFactory
     */
    private $transportFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

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
     * @var string[]
     */
    private $ignoredMessages;

    /**
     * @var UdpTransport
     */
    private $transporter;

    public function __construct(
        UdpTransportFactory $transportFactory,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        string $hostPath,
        string $portPath,
        string $chunkSize = UdpTransport::CHUNK_SIZE_LAN,
        array $ignoredMessages = []
    ) {
        $this->transportFactory = $transportFactory;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->hostPath = $hostPath;
        $this->portPath = $portPath;
        $this->chunkSize = $chunkSize;
        $this->ignoredMessages = $ignoredMessages;
        unset($this->transporter);
    }

    public function __get(string $name)
    {
        if ($name === 'transporter') {
            return $this->{$name} = $this->createTransporter();
        }

        return null;
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
        if (!in_array($message->getShortMessage(), $this->ignoredMessages, true)) {
            try {
                return $this->transporter->send($message);
            } catch (Exception $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());
            }
        }

        return 0;
    }

    private function createTransporter(): UdpTransport
    {
        return $this->transportFactory->create([
            'host' => $this->scopeConfig->getValue($this->hostPath),
            'port' => $this->scopeConfig->getValue($this->portPath),
            'chunkSize' => $this->chunkSize
        ]);
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Client\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder as ClientBuilder8;
use Elasticsearch\ClientBuilder as ClientBuilder7;
use RuntimeException;

class ElasticsearchClientFactory
{
    public static function create(): ClientBuilder7|ClientBuilder8
    {
        if (class_exists(ClientBuilder8::class)) {
            return ClientBuilder8::create();
        }

        if (class_exists(ClientBuilder7::class)) {
            return ClientBuilder7::create();
        }

        throw new RuntimeException('No compatible Elasticsearch ClientBuilder found.');
    }
}

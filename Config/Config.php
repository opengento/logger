<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Config;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    /** Config keys */
    public const CONFIG_LOGGER_CUSTOM_CONFIGURATION = 'loggin/context/types_logger';
}

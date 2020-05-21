<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types = 1);

namespace Opengento\Logger\Traits;

trait VerifyConfiguration
{
    /**
     * @return bool
     */
    private function isEnabled(){
        return $this->scopeConfig->getValue($this->isEnabled) === '1';
    }

    /**
     * @param array $record
     * @return bool|void
     * @throws \Exception
     */
    public function handle(array $record)
    {
        if($this->isEnabled()){
            $this->getInstance()->handle($record);
        }
    }
}

<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */

declare(strict_types=1);

namespace Opengento\Logger\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Type extends AbstractFieldArray
{
    protected function _construct()
    {
        $this->addColumn('custom_logger_key', ['label' => __('Logger key')]);
        $this->addColumn('custom_logger_value', ['label' => __('Logger value')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
        parent::_construct();
    }
}

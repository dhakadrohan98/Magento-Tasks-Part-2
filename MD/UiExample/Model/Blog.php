<?php

namespace MD\UiExample\Model;

use Magento\Framework\Model\AbstractModel;
use MD\UiExample\Model\ResourceModel\Blog as BlogResourceModel;

class Blog extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }
}
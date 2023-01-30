<?php
namespace Task\ProductAttribute\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class StatusOptions extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options=[
                ['label' => __('Kg'), 'value' => 0],
                ['label' => __('Litre'), 'value' => 1],
                ['label' => __('mL'), 'value' => 2],
                ['label' => __('Packets'), 'value' => 3]
            ];
        }
        return $this->_options;
    }
}
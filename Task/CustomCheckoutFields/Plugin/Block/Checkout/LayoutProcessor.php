<?php

namespace Sigma\CustomCheckoutFields\Plugin\Block\Checkout;

class LayoutProcessor
{
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject,$jsLayout)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['delivery_date'] =
            $this->processDeliveryDateAddress('shippingAddress');

        return $jsLayout;
    }

    private function processDeliveryDateAddress($dataScopePrefix)
    {
        return [
            'component' => 'Magento_Ui/js/form/element/date',
            'config' => [
                'customScope' => $dataScopePrefix.'custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/date',
                'id' => 'delivery_date',
                'options' => [
                    'dateFormat' => 'y-MM-dd'
                ]
            ],
            'dataScope' => $dataScopePrefix.'custom_attributes.delivery_date',
            'label' => __('Delivery Date'),
            'provider' => 'checkoutProvider',
            'validation' => [
                'required-entry' => true
            ]
        ];
    }
}
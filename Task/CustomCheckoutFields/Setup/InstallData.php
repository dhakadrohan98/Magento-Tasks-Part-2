<?php

namespace Sigma\CustomCheckoutFields\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Tests\NamingConvention\true\false;

class InstallData implements InstallDataInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * InstallData constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->addDeliveryDateAttribute($setup);
    }

    protected function addDeliveryDateAttribute($setup)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup'=> $setup]);

        if (!$customerSetup->getAttributeId('customer_address', 'delivery_date')) {
            $customerSetup->addAttribute('customer_address', 'delivery_date', [
            'type' => 'varchar',
            'label' => 'Delivery Date',
            'input' => 'hidden',
            'required' => false,
            'visible' => true,
            'system' => 0,
            'visible_on_front' => false,
            'sort_order' => -101,
            'position' => 101
            ]);
        }
    }
}
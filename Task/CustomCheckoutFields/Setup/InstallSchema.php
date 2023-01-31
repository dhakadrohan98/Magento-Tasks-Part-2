<?php

namespace Sigma\CustomCheckoutFields\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $this->addDeliveryDateColumn($setup);
        $installer->endSetup();
    }

    private function addDeliveryDateColumn(SchemaSetupInterface $setup)
    {
        $deliveryDate = [
            'type' => TABLE::TYPE_DATE,
            'default' => NULL,
            'nullable' => true,
            'comment' => 'Delivery Date'
        ];

        $setup->getConnection->addColumn($setup->getTable('sales_order_address'), 'delivery_date', $deliveryDate);
        $setup->getConnection->addColumn($setup->getTable('quote_address'), 'delivery_date', $deliveryDate);

    }
}

<?php
namespace Sigma\ServiceModel\Model\ResourceModel\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'sigma_servicemodel_grid_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'grid_collection';

    /**
     * Collection constructor.
     *
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param null|string $resourceModel
     */
    // @codingStandardsIgnoreLine
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'purchase_order',
        $resourceModel = \Sigma\ServiceModel\Model\ResourceModel\Grid\Collection::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * BeforeLoad() method.
     *
     * @return $this
     */
    public function _beforeLoad()
    {

        $this->getSelect()->joinLeft(
            ['customer_entity' => $this->getTable('customer_entity')],
            'customer_entity.entity_id = main_table.customer_id',
            ['customername' => "CONCAT(customer_entity.firstname, ' ', customer_entity.lastname)"]
        );
        $this->getSelect()->joinLeft(
            ['admin_user' => $this->getTable('admin_user')],
            'admin_user.user_id = main_table.admin_user_id',
            ['adminname' => "admin_user.firstname"]
        );

        return parent::_beforeLoad();
    }

    /**
     * LoadWithFilter method.
     *
     * @param bool $printQuery
     * @param bool $logQuery
     * @return $this
     */
    public function loadWithFilter(
        $printQuery = false,
        $logQuery = false
    ) {
        $this->getSelect()->
        columns(['customername' =>  "CONCAT(customer_entity.firstname, ' ', customer_entity.lastname)"]);
        $this->getSelect()->columns(['adminname' =>  "admin_user.firstname"]);
        return parent::loadWithFilter($printQuery, $logQuery);
    }

    /**
     * AddFieldToFilter method
     *
     * @param array|string $field
     * @param boolean $condition
     * @return $this
     */
    public function addFieldToFilter(
        $field,
        $condition = null
    ) {
        $fieldMap = $this->getFilterFieldsMap();
        if (is_array($field)) {
            foreach ($field as $singleField) {
                if (!isset($fieldMap['fields'][$singleField])) {
                    return parent::addFieldToFilter($field, $condition);
                }
            }
        } else {
            if (!isset($fieldMap['fields'][$field])) {
                return parent::addFieldToFilter($field, $condition);
            }
        }

        $fieldName = $fieldMap['fields'][$field];

        if (!in_array($field, ['customername'])) {
            $fieldName = $this->getConnection()->quoteIdentifier($fieldName);
        }
        // if (!in_array($field, ['adminname'])) {
        //     $fieldName = $this->getConnection()->quoteIdentifier($fieldName);
        // }

        $condition = $this->getConnection()->prepareSqlCondition($fieldName, $condition);
        $this->getSelect()->where($condition, null, \Magento\Framework\DB\Select::TYPE_CONDITION);

        return $this;
    }

    /**
     * GetFilterFieldsMap method
     *
     * @return array
     */
    private function getFilterFieldsMap()
    {

        return [
            'fields' => [
                'customername' => "CONCAT(customer_entity.firstname, ' ', customer_entity.lastname)",
                'adminname' => "admin_user.firstname",
            ]
        ];
    }

    /**
     * InitSelect Method
     *
     * @return $this
     */
    protected function _initSelect()
    {
        $this->addFilterToMap('customername', 'customer_entity.customername');
        $this->addFilterToMap('adminname', 'admin_user.firstname');
        parent::_initSelect();
    }
}

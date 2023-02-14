<?php

namespace Sigma\ServiceModel\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Sigma\ServiceModel\Model\ResourceModel\Grid\Collection;

class CustomerFile extends Column
{
    /**
     * @var \Magento\Customer\Model\Customer $customer
     */
    protected $customers;

    /**
     * @var \Sigma\ServiceModel\Model\ResourceModel\Grid\CollectionFactory
     */
    protected $gridCollectionFactory;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $directory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * CustomerFile constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Customer\Model\Customer $customers
     * @param \Sigma\ServiceModel\Model\GridFactory $gridCollectionFactory
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Filesystem\DirectoryList $directory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Customer\Model\Customer $customers,
        \Sigma\ServiceModel\Model\GridFactory $gridCollectionFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->_customers = $customers;
        $this->gridCollectionFactory = $gridCollectionFactory;
        $this->_downloader = $fileFactory;
        $this->directory = $directory;
        $this->storeManager = $storeManager;
    }
    /**
     * Return Customer Name from Customer Id
     *
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $id = $item['id'];
                    $requestCollection = $this->gridCollectionFactory->create();
                    $requestCollection->load($id);
                    $fileName = $requestCollection->getCustomerFile();
                    $filePath = $requestCollection->getCustomerFileName();
                    $currentStore = $this->storeManager->getStore();
                    $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                    $file = $mediaUrl . "allrequests" . $filePath;
                    $item[$fieldName] = "<a href='" . $file . "' download>" . $fileName . "</a>";
                }
            }
        }
        return $dataSource;
    }
}

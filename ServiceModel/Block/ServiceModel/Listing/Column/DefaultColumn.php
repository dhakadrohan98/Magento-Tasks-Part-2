<?php
namespace Sigma\ServiceModel\Block\ServiceModel\Listing\Column;

use Magento\Framework\View\Element\Template;
use Sigma\ServiceModel\Api\Data\GridInterface;
use Sigma\ServiceModel\Model\ResourceModel\Grid\Collection;

class DefaultColumn extends Template
{
    /**
     * @var \Sigma\ServiceModel\Model\ResourceModel\Grid\CollectionFactory
     */
    protected $gridCollectionFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * DefaultColumn constructor.
     *
     * @param Template\Context $context
     * @param \Sigma\ServiceModel\Model\GridFactory $gridCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sigma\ServiceModel\Model\GridFactory $gridCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->gridCollectionFactory = $gridCollectionFactory;
        $this->storeManager = $storeManager;
    }
    /**
     * Get label method
     *
     * @return string
     */
    public function getLabel()
    {
        return __($this->getData('label'));
    }

    /**
     * Get Item method
     *
     * @return GridInterface
     */
    public function getItem()
    {
        return $this->getData('item');
    }

    /**
     * Get Column method
     *
     * @return string
     */
    public function getColumn()
    {
        return $this->getNameInLayout();
    }

    /**
     * Return Customer File Location function
     *
     * @param integer $id
     * @return String
     */
    public function getCustomerMediaUrl(int $id)
    {
        $requestCollection = $this->gridCollectionFactory->create();
        $requestCollection->load($id);
        $fileName = $requestCollection->getCustomerFileName();
        $filePath = $requestCollection->getCustomerFile();
        $currentStore = $this->storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $file = $mediaUrl . "allrequests/" . $filePath;
        return $file;
    }
    /**
     * Return Admin File Location function
     *
     * @param integer $id
     * @return String
     */
    public function getAdminMediaUrl(int $id)
    {
        $requestCollection = $this->gridCollectionFactory->create();
        $requestCollection->load($id);
        $fileName = $requestCollection->getAdminFileName();
        $filePath = $requestCollection->getAdminFile();
        $currentStore = $this->storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $file = $mediaUrl . "adminrequests/" . $filePath;
        return $file;
    }
}

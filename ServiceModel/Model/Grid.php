<?php
namespace Sigma\ServiceModel\Model;

use Sigma\ServiceModel\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    public const CACHE_TAG = 'sigma_service';
    /**
     * @var string
     */
    protected $_cacheTag = 'sigma_service';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'sigma_service';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Sigma\ServiceModel\Model\ResourceModel\Grid::class);
    }
    /**
     * Get Id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set Id.
     *
     * @param int $id
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
     /**
      * Get Customer Id.
      *
      * @return int
      */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set Customer Id.
     *
     * @param int $customerId
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get Customer File.
     *
     * @return varchar
     */
    public function getCustomerFile()
    {
        return $this->getData(self::CUSTOMER_FILE);
    }

    /**
     * Set  Customer File.
     *
     * @param string $customerFile
     */
    public function setCustomerFile($customerFile)
    {
        return $this->setData(self::CUSTOMER_FILE, $customerFile);
    }

    /**
     * Get InsertDate.
     *
     * @return varchar
     */
    public function getInsertDate()
    {
        return $this->getData(self::INSERT_DATE);
    }

    /**
     * Set InsertDate.
     *
     * @param string $insertDate
     */
    public function setInsertDate($insertDate)
    {
        return $this->setData(self::INSERT_DATE, $insertDate);
    }
     /**
      * Get Reply.
      *
      * @return int
      */
    public function getIsReply()
    {
        return $this->getData(self::IS_REPLY);
    }

    /**
     * Set Reply.
     *
     * @param boolean $isReply
     */
    public function setIsReply($isReply)
    {
        return $this->setData(self::IS_REPLY, $isReply);
    }

     /**
      * Get ReplyDate.
      *
      * @return varchar
      */
    public function getReplyDate()
    {
        return $this->getData(self::REPLY_DATE);
    }

    /**
     * Set ReplyDate.
     *
     * @param string $replyDate
     */
    public function setReplyDate($replyDate)
    {
        return $this->setData(self::REPLY_DATE, $replyDate);
    }
     /**
      * Get Admin User Id.
      *
      * @return int
      */
    public function getAdminUserId()
    {
        return $this->getData(self::ADMIN_USER_ID);
    }

    /**
     * Set Admin User Id.
     *
     * @param int $adminUserId
     */
    public function setgetAdminUserId($adminUserId)
    {
        return $this->setData(self::ADMIN_USER_ID, $adminUserId);
    }
    /**
     * Get Admin File.
     *
     * @return varchar
     */
    public function getAdminFile()
    {
        return $this->getData(self::ADMIN_FILE);
    }

    /**
     * Set Admin File.
     *
     * @param string $adminFile
     */
    public function setAdminFile($adminFile)
    {
        return $this->setData(self::ADMIN_FILE, $adminFile);
    }
    /**
     * Get Customer File.
     *
     * @return varchar
     */
    public function getCustomerFileName()
    {
        return $this->getData(self::CUSTOMER_FILE_NAME);
    }

    /**
     * Set  Customer File.
     *
     * @param string $customerFileName
     */
    public function setCustomerFileName($customerFileName)
    {
        return $this->setData(self::CUSTOMER_FILE_NAME, $customerFileName);
    }
    /**
     * Get Admin File Name.
     *
     * @return varchar
     */
    public function getAdminFileName()
    {
        return $this->getData(self::ADMIN_FILE);
    }

    /**
     * Set Admin File Name.
     *
     * @param string $adminFileName
     */
    public function setAdminFileName($adminFileName)
    {
        return $this->setData(self::ADMIN_FILE_NAME, $adminFileName);
    }
}

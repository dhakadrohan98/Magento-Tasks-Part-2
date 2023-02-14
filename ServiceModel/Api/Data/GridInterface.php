<?php
namespace Sigma\ServiceModel\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ID = 'id';
    public const CUSTOMER_ID = 'customer_id';
    public const CUSTOMER_FILE = 'customer_file';
    public const INSERT_DATE = 'insert_date';
    public const IS_REPLY = 'is_reply';
    public const REPLY_DATE = 'reply_date';
    public const ADMIN_USER_ID = 'admin_user_id';
    public const ADMIN_FILE = 'admin_file';
    public const CUSTOMER_FILE_NAME = 'customer_file_name';
    public const ADMIN_FILE_NAME = 'admin_file_name';
    /**
     * Get Id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set Id.
     *
     * @param int $id
     */
    public function setId($id);

     /**
      * Get Customer Id.
      *
      * @return int
      */
    public function getCustomerId();

    /**
     * Set Customer Id.
     *
     * @param int $customerId
     */
    public function setCustomerId($customerId);

    /**
     * Get Customer File.
     *
     * @return varchar
     */
    public function getCustomerFile();

    /**
     * Set  Customer File.
     *
     * @param file $customerFile
     */
    public function setCustomerFile($customerFile);

    /**
     * Get InsertDate.
     *
     * @return varchar
     */
    public function getInsertDate();

    /**
     * Set InsertDate.
     *
     * @param date $insertDate
     */
    public function setInsertDate($insertDate);

     /**
      * Get Reply.
      *
      * @return int
      */
    public function getIsReply();
    /**
     * Set Reply.
     *
     * @param boolean $isReply
     */
    public function setIsReply($isReply);

     /**
      * Get ReplyDate.
      *
      * @return varchar
      */
    public function getReplyDate();

    /**
     * Set ReplyDate.
     *
     * @param date $replyDate
     */
    public function setReplyDate($replyDate);

     /**
      * Get Admin User Id.
      *
      * @return int
      */
    public function getAdminUserId();

    /**
     * Set Admin User Id.
     *
     * @param int $adminUserId
     */
    public function setgetAdminUserId($adminUserId);

    /**
     * Get Admin File.
     *
     * @return varchar
     */
    public function getAdminFile();
    /**
     * Set Admin File.
     *
     * @param file $adimFile
     */
    public function setAdminFile($adimFile);
    /**
     * Get Admin File Name.
     *
     * @return varchar
     */
    public function getAdminFileName();
    /**
     * Set Admin File Name.
     *
     * @param string $adimFile
     */
    public function setAdminFileName($adimFile);
    /**
     * Get Customer File Name.
     *
     * @return varchar
     */
    public function getCustomerFileName();

    /**
     * Set  Customer File Name.
     *
     * @param file $customerFile
     */
    public function setCustomerFileName($customerFile);
}

<?php
namespace Sigma\ServiceModel\Block\ServiceModel;

use Zend\Log\Filter\Timestamp;
use Magento\Store\Model\StoreManagerInterface;

class Create extends \Magento\Framework\View\Element\Template
{
    public const XML_PATH_EMAIL_RECIPIENT_NAME = 'trans_email/ident_support/name';
    public const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';
    /**
     * @var \Magento\Framework\Url
     */
    private $urlManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_date;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $_inlineTranslation;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    protected $_scopeConfig;
    /**
     * @var \Psr\Log\LoggerInterface $loggerInterface
     */
    protected $_logLoggerInterface;
    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * Create constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Url $urlManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Psr\Log\LoggerInterface $loggerInterface
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Url $urlManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->urlManager = $urlManager;
        $this->customerSession = $customerSession;
        $this->_date =  $date;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->storeManager = $storeManager;
    }

    /**
     * Prepare Layout method
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('Create Request'));
        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle(__('Create Request'));
        }
    }
    /**
     * Get Current Customer Id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerSession->getCustomer()->getId();
    }
    /**
     * Get Current Date
     *
     * @return date
     */
    public function getCurrentDate()
    {
        return $this->_date->date()->format('Y-m-d H:i:s');
    }
    /**
     * Send Mail to Admin after a service request function
     *
     * @param [String] $name
     * @param [String] $email
     * @param [String] $customerFileName
     * @param [String] $customerFile
     * @return void
     */
    public function sendMailToAdmin($name, $email, $customerFileName, $customerFile)
    {
        $sender = [
            'name' => $name,
            'email' => $email
        ];
        $sentToEmail = $this->_scopeConfig->
        getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $sentToName = $this->_scopeConfig->
        getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $currentStore = $this->storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $customerFileUrl = $mediaUrl . "allrequests" . $customerFileName;

        $transport = $this->_transportBuilder->
        setTemplateIdentifier('service_new_request_email_template')->setTemplateOptions(
            [
                'area' => 'frontend',
                'store' => $this->storeManager->getStore()->getId()
            ]
        )
            ->setTemplateVars([
                'name'  => $name,
                'email'  => $email,
                'customerFileUrl' => $customerFileUrl,
                'customerFile' => $customerFile
            ])
            ->setFromByScope($sender)
            ->addTo($sentToEmail, $sentToName)
            ->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }
    /**
     * Send Acknowledge Mail From Admin
     *
     * @param [String] $name
     * @param [String] $email
     */
    public function acknowledgeMailFromAdmin($name, $email)
    {
        $sender = [
            'name' => $this->_scopeConfig->
            getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'email' => $this->_scopeConfig->
            getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        ];
        $sentToEmail = $email;
        $sentToName = $name;

        $transport = $this->_transportBuilder->
        setTemplateIdentifier('acknowledge_from_admin_email_template')->setTemplateOptions(
            [
                'area' => 'frontend',
                'store' => $this->storeManager->getStore()->getId()
            ]
        )
            ->setTemplateVars([
                'name'  => $name,
                'email'  => $email
            ])
            ->setFromByScope($sender)
            ->addTo($sentToEmail, $sentToName)
            ->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }
    /**
     * Send Mail From Admin after a admin uploads file
     *
     * @param [String] $name
     * @param [String] $email
     * @param [String] $adminFile
     * @param [String] $adminFileName
     * @return void
     */
    public function sendMailFromAdmin($name, $email, $adminFile, $adminFileName)
    {
        $sender = [
            'name' => $this->_scopeConfig->
            getValue('trans_email/ident_general/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'email' => $this->_scopeConfig->
            getValue('trans_email/ident_general/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        ];
        $sentToEmail = $email;
        $sentToName = $name;

        $currentStore = $this->storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $adminFileUrl = $mediaUrl . "adminrequests/" . $adminFile;

        $transport = $this->_transportBuilder->
        setTemplateIdentifier('admin_reply_request_email_template')->setTemplateOptions(
            [
                'area' => 'frontend',
                'store' => $this->storeManager->getStore()->getId()
            ]
        )
            ->setTemplateVars([
                'name'  => $name,
                'email'  => $email,
                'adminFileUrl' => $adminFileUrl,
                'adminFile' => $adminFileName
            ])
            ->setFromByScope($sender)
            ->addTo($sentToEmail, $sentToName)
            ->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }
}

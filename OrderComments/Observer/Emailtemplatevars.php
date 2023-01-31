<?php
namespace Task\OrderComments\Observer;

/**
 * Class Emailtemplatevars
 * @package Task\OrderComments\Observer
 */
class Emailtemplatevars implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $transport = $observer->getEvent()->getTransport();
        if ($transport->getOrder() != null) {
            $transport['Taskordercomment'] = $transport->getOrder()->getTaskOrderComments();
        }
    }
}

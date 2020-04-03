<?php
namespace Sga\MediaSync\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Sga\MediaSync\Helper\Data as HelperData;

class SendResponseBefore implements ObserverInterface
{
    protected $_helper;

    public function __construct(
        HelperData $helper
    ){
        $this->_helper = $helper;
    }

    public function execute(Observer $observer)
    {
        $response = $observer->getEvent()->getResponse();
        $html = $response->getBody();
        $this->_helper->syncMediaByHtml($html);
    }
}

<?php

namespace Sga\MediaSync\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    protected $_scopeConfig;

    const XML_PATH_ENABLED = 'dev/sga_mediasync/enabled';
    const XML_PATH_SOURCE_URL = 'dev/sga_mediasync/source_url';

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context
    )
    {
        $this->_scopeConfig = $scopeConfig;

        parent::__construct($context);
    }

    public function isEnabled($store = null)
    {
        return $this->_scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getSourceUrl($store = null)
    {
        return $this->_scopeConfig->getValue(
            self::XML_PATH_SOURCE_URL,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}

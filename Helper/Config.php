<?php

namespace Sga\MediaSync\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const XML_PATH_ENABLED = 'dev/sga_mediasync/enabled';
    const XML_PATH_SOURCE_URL = 'dev/sga_mediasync/source_url';
    const XML_PATH_HTACCESS_USER = 'dev/sga_mediasync/htaccess_user';
    const XML_PATH_HTACCESS_PASSWORD = 'dev/sga_mediasync/htaccess_password';

    public function isEnabled($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getSourceUrl($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SOURCE_URL,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getHtaccessUser($store = null)
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_HTACCESS_USER,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getHtaccessPassword($store = null)
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_HTACCESS_PASSWORD,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}

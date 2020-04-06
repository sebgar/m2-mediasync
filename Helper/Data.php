<?php
namespace Sga\MediaSync\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Sga\MediaSync\Helper\Config;

class Data extends AbstractHelper
{
    protected $_patternMediaFolder = 'media';
    protected $_config;
    protected $_request;
    protected $_directorylist;
    protected $_storeManager;

    public function __construct(
        Context $context,
        Config $config,
        RequestInterface $request,
        DirectoryList $directorylist,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_config = $config;
        $this->_request = $request;
        $this->_directorylist = $directorylist;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;

        parent::__construct($context);
    }

    protected function _getPatterns()
    {
        $list = [];
        $nodes = $this->_scopeConfig->get('system', 'default/dev/sga_mediasync/patterns');
        if (is_array($nodes)) {
            foreach ($nodes as $key => $node) {
                $list[] = $node;
            }
        }
        return $list;
    }

    public function syncMediaByHtml($html)
    {
        if ($this->_config->isEnabled()) {
            $patterns = $this->_getPatterns();
            foreach ($patterns as $pattern) {
                $matches = array();
                if (preg_match_all($pattern, $html, $matches)) {
                    foreach ($matches[1] as $match) {
                        $this->syncFile($match);
                    }
                }
            }
        }
    }

    public function getMediaUrl($url)
    {
        if ($this->_config->isEnabled()) {
            $path = $this->_directorylist->getPath('media') . DIRECTORY_SEPARATOR . $url;
            $this->syncFile($path);

            return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $url;
        }
    }

    public function syncFile($path)
    {
        $savedPath = $path;
        if ($this->_config->isEnabled()) {
            if (preg_match('#^http#', $path)) {
                $partsPath = explode('/'.$this->_patternMediaFolder.'/', $path);
                array_shift($partsPath);
                $path = $this->_directorylist->getPath('media').DIRECTORY_SEPARATOR.implode('/'.$this->_patternMediaFolder.'/', $partsPath);
            }

            if (!file_exists($path)) {
                $url = $this->_getSourceUrl($path);
                if ($url != '') {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    $data = curl_exec($curl);

                    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
                        if (!file_exists(dirname($path))) {
                            mkdir(dirname($path), 0755, true);
                        }
                        $handle = fopen($path, 'w');
                        if ($handle) {
                            fwrite($handle, $data);
                            fclose($handle);
                        }
                    }
                    curl_close($curl);
                }
            }
        }

        return $savedPath;
    }

    protected function _getSourceUrl($path)
    {
        $partsPath = explode('/'.$this->_patternMediaFolder.'/', $path);
        array_shift($partsPath);

        $currentUrl = $this->_request->getScheme().'://'.$this->_request->getHttpHost();
        $sourceUrl = trim($this->_config->getSourceUrl(), '/');
        if ($currentUrl == $sourceUrl) {
            return '';
        }
        return $sourceUrl.'/'.$this->_patternMediaFolder.'/'.implode('/'.$this->_patternMediaFolder.'/', $partsPath);
    }
}

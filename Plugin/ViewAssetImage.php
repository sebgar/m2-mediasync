<?php
namespace Sga\MediaSync\Plugin;

use Magento\Catalog\Model\View\Asset\Image as Subject;
use Sga\MediaSync\Helper\Data as HelperData;

class ViewAssetImage
{
    protected $_helper;

    public function __construct(
        HelperData $helper
    ){
        $this->_helper = $helper;
    }

    public function beforeGetUrl(Subject $subject)
    {
        $this->_helper->getMediaUrl('catalog'.DIRECTORY_SEPARATOR.'product'.$subject->getFilePath());
    }
}

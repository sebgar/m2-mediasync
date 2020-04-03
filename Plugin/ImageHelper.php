<?php

namespace Sga\MediaSync\Plugin;

use Magento\Catalog\Helper\Image as CatalogImageHelper;
use Sga\MediaSync\Helper\Data as HelperData;

class ImageHelper
{
    protected $_helper;

    public function __construct(
        HelperData $helper
    ){
        $this->_helper = $helper;
    }

    public function beforeSetImageFile(CatalogImageHelper $helper, $file)
    {
        $this->_helper->getMediaUrl('catalog'.DIRECTORY_SEPARATOR.'product'.$file);

        return [$file];
    }
}

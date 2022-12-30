<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class CexConfigOffice implements ConfigProviderInterface
{
    /** @var LayoutInterface  */
    protected $_layout;

    public function __construct(LayoutInterface $layout)
    {
        $this->_layout = $layout;
    }

    public function getConfig()
    {
        $myBlockId = "rec_ofi_cex_block"; // CMS Block Identifier
        //$myBlockId = 20; // CMS Block ID

        return [
            'rec_ofi_cex_block_content' => $this->_layout->createBlock('Magento\Cms\Block\Block')->setBlockId($myBlockId)->toHtml()
        ];
    }
}
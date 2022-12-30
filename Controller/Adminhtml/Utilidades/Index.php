<?php
namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Utilidades;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Store\Api\Data\StoreInterface;

/**
 * Class Index
 */
class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'CorreosExpress_RegistroDeEnvios::utilidades';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $storeInterface;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        StoreInterface $storeInterface
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->storeInterface=$storeInterface;
    }

    /**
     * Load the page defined in view/adminhtml/layout/correosexpress_utilidades_index.xml
     *
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Utilidades'));

        return $resultPage;
    }
}

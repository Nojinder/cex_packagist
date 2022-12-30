<?php
namespace CorreosExpress\RegistroDeEnvios\CexCron;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;


class CexCron extends Action
{
    protected $_pageFactory;
    protected $_cexHelpers;
    protected $context;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */

    public function __construct(         
        Context $context,
        PageFactory $pageFactory,
        \CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers\Index $cexHelpers
    	){
        $this->_pageFactory = $pageFactory;
        $this->_cexHelpers = $cexHelpers;
        parent::__construct($context);        

    }

	public function execute()
	{	
        $resultPage = $this->_pageFactory->create();
        $this->_cexHelpers->ejecutarCexCron();
        return $resultPage;
	}
}
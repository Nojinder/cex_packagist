<?php
namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Index;
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $_cexMigrationFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \CorreosExpress\RegistroDeEnvios\Model\CexMigrationFactory $cexMigrationFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_cexMigrationFactory = $cexMigrationFactory;
        return parent::__construct($context);
    }


    public function execute()
    {
        $migraciones = $this->_cexMigrationFactory->create();
        $collection = $migraciones->getCollection();
        foreach ($collection as $migracion) {
            echo "<pre>";
            print_r($migracion->getData());
            echo "</pre>";
        }
        exit();
        return $this->_pageFactory->create();
    }

    
}

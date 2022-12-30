<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel;
class CexEnviobultos extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context)
    {
        parent::__construct($context);
    }


    protected function _construct()
    {
        $this->_init('correosexpress_registrodeenvios_cexenviobultos', 'enviobultos_id');
    }


}

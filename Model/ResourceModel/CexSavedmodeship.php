<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel;
class CexSavedmodeship extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context)
    {
        parent::__construct($context);
    }


    protected function _construct()
    {
        $this->_init('correosexpress_registrodeenvios_cexsavedmodeships', 'modeships_id');
    }

}

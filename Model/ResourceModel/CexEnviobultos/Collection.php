<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnviobultos;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'enviobultos_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexenviobultos_collection';
    protected $_eventObject = 'cexenviobultos_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexEnviobultos',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnviobultos');
    }



}

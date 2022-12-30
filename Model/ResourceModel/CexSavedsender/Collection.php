<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedsender;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'sender_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexsavedsenders_collection';
    protected $_eventObject = 'cexsavedsenders_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexSavedsender',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedsender');
    }



}

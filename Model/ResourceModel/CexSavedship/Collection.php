<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'ship_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexsavedships_collection';
    protected $_eventObject = 'cexsavedships_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexSavedship',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship');
    }
}

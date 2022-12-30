<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedmodeship;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'modeships_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexsavedmodeships_collection';
    protected $_eventObject = 'cexsavedmodeships_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexSavedmodeship',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedmodeship');
    }



}

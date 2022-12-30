<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexHistory;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'history_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexhistory_collection';
    protected $_eventObject = 'cexhistory_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexHistory',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexHistory');
    }



}

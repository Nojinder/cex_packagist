<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomeroption;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'customer_options_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexcustomeroptions_collection';
    protected $_eventObject = 'cexcustomeroptions_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexCustomeroption',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomeroption');
    }



}

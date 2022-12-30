<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'customer_code_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexcustomercodes_collection';
    protected $_eventObject = 'cexcustomercodes_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexCustomercode',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode');
    }



}

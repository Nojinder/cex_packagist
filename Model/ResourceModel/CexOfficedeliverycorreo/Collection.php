<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexOfficedeliverycorreo;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'officedeliverycorreo_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexofficedeliverycorreo_collection';
    protected $_eventObject = 'cexofficedeliverycorreo_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexOfficedeliverycorreo',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexOfficedeliverycorreo');
    }



}

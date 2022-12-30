<?php
namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexMigration;
Class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'migration_id';
    protected $_eventPrefix = 'correosexpress_registrodeenvios_cexmigrations_collection';
    protected $_eventObject = 'cexmigration_collection';


    protected function _construct()
    {
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\CexMigration',
                     'CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexMigration');
    }



}

<?php

namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnvioCron;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnvioCron;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\CorreosExpress\RegistroDeEnvios\Model\CexEnvioCron::class, 
                     CexEnvioCron::class);
    }
}
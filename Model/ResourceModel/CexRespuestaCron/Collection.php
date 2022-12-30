<?php

namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexRespuestaCron;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexRespuestaCron;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\CorreosExpress\RegistroDeEnvios\Model\CexRespuestaCron::class, 
                     CexRespuestaCron::class);
    }
}
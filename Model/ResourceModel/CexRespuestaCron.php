<?php

namespace CorreosExpress\RegistroDeEnvios\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CexRespuestaCron extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('correosexpress_registrodeenvios_cexrespuestacron', 'id_respuesta_cron');
    }
}
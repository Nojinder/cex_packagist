<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\DataObject\IdentityInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface;

Class CexMigration extends AbstractExtensibleModel implements CexMigrationInterface, IdentityInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexmigrations";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexmigrations";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexmigrations";


    protected function _construct()
    {
        $this->_init(ResourceModel\CexMigration::class);
    }

    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    public function getDefaultValues(): array
    {
        $values = [];
        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrationId(): ?int
    {
        return parent::getData(self::MIGRATION_ID);
    }
    /**
     * {@inheritdoc}
     */
    public function setMigrationId(?int $id)
    {
        return $this->setData(self::MIGRATION_ID, $id);
    }
    /**
     * {@inheritdoc}
     */
    public function getMetodoEjecutado(): string
    {
        return parent::getData(self::METODO_EJECUTADO);
    }
    /**
     * {@inheritdoc}
     */
    public function setMetodoEjecutado(string $metodoEjecutado)
    {
        return parent::setData(self::METODO_EJECUTADO, $metodoEjecutado);
    }
    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }
    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($created_at)
    {
        return parent::getData(self::CREATED_AT, $created_at);
    }
}




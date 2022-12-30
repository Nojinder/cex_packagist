<?php
namespace CorreosExpress\RegistroDeEnvios\Model;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexEnviobultos extends AbstractExtensibleModel
              implements IdentityInterface, CexEnviobultosInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexenviobultos";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexenviobultos";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexenviobultos";


    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnviobultos');
    }

    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];

    }

    public function getDefaultValues(){
        $values = [];
        return $values;
    }

    /**
     * @inheritDoc
     */
    public function getEnviobultosId(): ?int
    {
        return $this->getData(self::ENVIOBULTOS_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEnviobultosId(?int $envioBultosId)
    {
        return $this->setData(self::ENVIOBULTOS_ID, $envioBultosId);
    }

    /**
     * @inheritDoc
     */
    public function getIdOrder(): ?int
    {
        return $this->getData(self::ID_ORDER);
    }

    /**
     * @inheritDoc
     */
    public function setIdOrder(?int $idOrder)
    {
        return $this->setData(self::ID_ORDER, $idOrder);
    }

    /**
     * @inheritDoc
     */
    public function getNumCollect(): string
    {
        return $this->getData(self::NUM_COLLECT);
    }

    /**
     * @inheritDoc
     */
    public function setNumCollect(string $numCollect)
    {
        return $this->setData(self::NUM_COLLECT, $numCollect);
    }

    /**
     * @inheritDoc
     */
    public function getNumShip(): string
    {
        return $this->getData(self::NUM_SHIP);
    }

    /**
     * @inheritDoc
     */
    public function setNumShip(string $numShip)
    {
        return $this->setData(self::NUM_SHIP, $numShip);
    }

    /**
     * @inheritDoc
     */
    public function getCodUnicoBulto(): string
    {
        return $this->getData(self::COD_UNICO_BULTO);
    }

    /**
     * @inheritDoc
     */
    public function setCodUnicoBulto(string $codUnicoBucle)
    {
        return $this->setData(self::COD_UNICO_BULTO, $codUnicoBucle);
    }

    /**
     * @inheritDoc
     */
    public function getIdBulto(): ?int
    {
        return $this->getData(self::ID_BULTO);
    }

    /**
     * @inheritDoc
     */
    public function setIdBulto(?int $idBulto)
    {
        return $this->setData(self::ID_BULTO, $idBulto);
    }

    /**
     * @inheritDoc
     */
    public function getFecha(): string
    {
        return $this->getData(self::FECHA);
    }

    /**
     * @inheritDoc
     */
    public function setFecha(string $fecha)
    {
        return $this->setData(self::FECHA, $fecha);
    }

    /**
     * @inheritDoc
     */
    public function getDeletedAt(): string
    {
        return $this->getData(self::DELETED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setDeletedAt(string $deletedAt)
    {
        return $this->setData(self::DELETED_AT, $deletedAt);
    }
}




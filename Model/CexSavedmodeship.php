<?php
namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexSavedmodeship extends AbstractExtensibleModel
              implements IdentityInterface, CexSavedmodeshipInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexsavedmodeships";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexsavedmodeships";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexsavedmodeships";

    /**
     * @return void
     */
    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedmodeship');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];

    }

    /**
     * @return array
     */
    public function getDefaultValues(): array
    {
        $values = [];
        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getModeShipsId(): ?int
    {
        return parent::getData(self::MODE_SHIPS_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setModeShipsId(?int $id)
    {
        return $this->setData(self::MODE_SHIPS_ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return parent::getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdBc(): string
    {
        return parent::getData(self::ID_BC);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdBc(string $idBc)
    {
        return $this->setData(self::ID_BC, $idBc);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdCarrier(): string
    {
        return parent::getData(self::ID_CARRIER);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdCarrier(string $idCarrier)
    {
        return $this->setData(self::ID_CARRIER, $idCarrier);
    }

    /**
     * {@inheritdoc}
     */
    public function getChecked(): int
    {
        return parent::getData(self::CHECKED);
    }

    /**
     * {@inheritdoc}
     */
    public function setChecked(int $checked)
    {
        return $this->setData(self::CHECKED, $checked);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdCustomerCode(): int
    {
        return parent::getData(self::ID_CUSTOMER_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdCustomerCode(int $idCustomercode)
    {
        return $this->setData(self::ID_CUSTOMER_CODE, $idCustomercode);
    }

    /**
     * {@inheritdoc}
     */
    public function getShortName(): string
    {
        return parent::getData(self::SHORT_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setShortName(string $shortName)
    {
        return $this->setData(self::SHORT_NAME, $shortName);
    }
}




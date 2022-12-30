<?php
namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexCustomercode extends AbstractExtensibleModel
              implements IdentityInterface, CexCustomercodeInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexcustomercodes";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexcustomercodes";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexcustomercodes";


    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode');
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
    public function getCustomerCodeId(): ?int
    {
        return $this->getData(self::CUSTOMER_CODE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerCodeId(?int $customerCodeId)
    {
        return $this->setData(self::CUSTOMER_CODE_ID, $customerCodeId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerCode(): string
    {
        return $this->getData(self::CUSTOMER_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerCode(string $customerCode)
    {
        return $this->setData(self::CUSTOMER_CODE, $customerCode);
    }

    /**
     * @inheritDoc
     */
    public function getCodeDemand(): string
    {
        return $this->getData(self::CODE_DEMAND);
    }

    /**
     * @inheritDoc
     */
    public function setCodeDemand(string $codeDemand)
    {
        return $this->setData(self::CODE_DEMAND, $codeDemand);
    }

    /**
     * @inheritDoc
     */
    public function getIdShop(): ?int
    {
        return $this->getData(self::ID_SHOP);
    }

    /**
     * @inheritDoc
     */
    public function setIdShop(?int $idShop)
    {
        return $this->setData(self::ID_SHOP, $idShop);
    }
}

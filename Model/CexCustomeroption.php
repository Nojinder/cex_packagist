<?php

namespace CorreosExpress\RegistroDeEnvios\Model;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface;

Class CexCustomeroption extends \Magento\Framework\Model\AbstractModel
              implements \Magento\Framework\DataObject\IdentityInterface,CexCustomeroptionInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexcustomeroptions";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexcustomeroptions";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexcustomeroptions";


    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomeroption');
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
    public function getCustomerOptionsId(): ?int
    {
        return parent::getData(self::CUSTOMER_OPTIONS_ID);
    }

     /**
     * @inheritDoc
     */
    public function setCustomerOptionsId(?int $customerOptionsId)
    {
        return $this->setData(self::CUSTOMER_OPTIONS_ID, $customerOptionsId);
    }

    /**
     * @inheritDoc
     */
    public function getClave(): string
    {
        return parent::getData(self::CLAVE);
    }

    /**
     * @inheritDoc
     */
    public function setClave(string $clave){
        return $this->setData(self::CLAVE, $clave);
    }

     /**
     * @inheritDoc
     */
    public function getValor(): string
    {
        return parent::getData(self::VALOR);
    }

     /**
     * @inheritDoc
     */
    public function setValor(string $valor){
        return $this->setData(self::VALOR, $valor);
    }
}

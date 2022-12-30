<?php
namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexOfficedeliverycorreo extends AbstractExtensibleModel
              implements IdentityInterface, CexOfficedeliverycorreoInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexofficedeliverycorreo";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexofficedeliverycorreo";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexofficedeliverycorreo";


    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexOfficedeliverycorreo');
    }

    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];

    }

    public function getDefaultValues(){
        $values = [];
        return $values;
    }
    /**
     * {@inheritdoc}
     */
    public function getOfficeDeliveryCorreoId(): ?int
    {
        return parent::getData(self::OFFICE_DELIVERY_CORREO_ID);
    }
    /**
     * {@inheritdoc}
     */
    public function setOfficeDeliveryCorreoId(?int $officeDeliveryOfficeId)
    {
        return $this->setData(self::OFFICE_DELIVERY_CORREO_ID, $officeDeliveryOfficeId);
    }
    /**
     * {@inheritdoc}
     */
    public function getIdCart(): ?int
    {
        return parent::getData(self::ID_CART);
    }
    /**
     * {@inheritdoc}
     */
    public function setIdCart(?int $idCart)
    {
        return $this->setData(self::ID_CART, $idCart);
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
    public function getIdCustomer(): ?int
    {
        return parent::getData(self::ID_CUSTOMER);
    }
    /**
     * {@inheritdoc}
     */
    public function setIdCustomer(?int $idCustomer)
    {
        return $this->setData(self::ID_CUSTOMER, $idCustomer);
    }
    /**
     * {@inheritdoc}
     */
    public function getCodigoOficina(): string
    {
        return parent::getData(self::CODIGO_OFICINA);
    }
    /**
     * {@inheritdoc}
     */
    public function setCodigoOficina(string $codigoOficina)
    {
        return $this->setData(self::CODIGO_OFICINA, $codigoOficina);
    }
    /**
     * {@inheritdoc}
     */
    public function getTextoOficina(): string
    {
        return parent::getData(self::TEXTO_OFICINA);
    }
    /**
     * {@inheritdoc}
     */
    public function setTextoOficina(string $textoOficina)
    {
        return $this->setData(self::TEXTO_OFICINA, $textoOficina);
    }
}




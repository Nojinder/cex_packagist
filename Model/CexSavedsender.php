<?php
namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexSavedsender extends AbstractExtensibleModel
              implements IdentityInterface, CexSavedsenderInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexsavedsenders";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexsavedsenders";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexsavedsenders";

    protected function _construct(){
        $this->_init(ResourceModel\CexSavedsender::class);
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
    public function getSenderId(): ?int
    {
        return $this->getData(self::SENDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderId(?int $senderId)
    {
        return $this->setData(self::SENDER_ID, $senderId);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
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
    public function getAddress(): string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress(string $address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostCode(): string
    {
        return $this->getData(self::POST_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPostCode(string $postCode)
    {
        return $this->setData(self::POST_CODE, $postCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getCity(): string
    {
        return $this->getData(self::CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setCity(string $city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * {@inheritdoc}
     */
    public function getContact(): string
    {
        return $this->getData(self::CONTACT);
    }

    /**
     * {@inheritdoc}
     */
    public function setContact(string $contact)
    {
        return $this->setData(self::CONTACT, $contact);
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone(): string
    {
        return $this->getData(self::PHONE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone(string $phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * {@inheritdoc}
     */
    public function getFromHour(): ?int
    {
        return $this->getData(self::FROM_HOUR);
    }

    /**
     * {@inheritdoc}
     */
    public function setFromHour(?int $fromHour)
    {
        return $this->setData(self::FROM_HOUR, $fromHour);
    }

    /**
     * {@inheritdoc}
     */
    public function getFromMinute(): ?int
    {
        return $this->getData(self::FROM_MINUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setFromMinute(?int $fromMinute)
    {
        return $this->setData(self::FROM_MINUTE, $fromMinute);
    }

    /**
     * {@inheritdoc}
     */
    public function getToHour(): ?int
    {
        return $this->getData(self::TO_HOUR);
    }

    /**
     * {@inheritdoc}
     */
    public function setToHour(?int $toHour)
    {
        return $this->setData(self::TO_HOUR, $toHour);
    }

    /**
     * {@inheritdoc}
     */
    public function getToMinute(): ?int
    {
        return $this->getData(self::TO_MINUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setToMinute(?int $toMinute)
    {
        return $this->setData(self::TO_MINUTE, $toMinute);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsoCodePais(): string
    {
        return $this->getData(self::ISO_CODE_PAIS);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsoCodePais(string $isoCodePais)
    {
        return $this->setData(self::ISO_CODE_PAIS, $isoCodePais);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(string $email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function getIdCodCliente(): ?int
    {
        return $this->getData(self::ID_COD_CLIENTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdCodCliente(?int $idCodCliente)
    {
        return $this->setData(self::ID_COD_CLIENTE, $idCodCliente);
    }
}




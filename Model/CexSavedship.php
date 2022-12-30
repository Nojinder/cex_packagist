<?php
namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexSavedship extends AbstractExtensibleModel
              implements IdentityInterface,CexSavedshipInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexSavedship";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexSavedship";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexSavedship";


    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship');
    }

    /**
     * @return string[]
     */
    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues(){
        $values = [];
        return $values;
    }

     /**
     * {@inheritdoc}
     */
    public function getSavedShipsId(): ?int
    {
        return $this->getData(self::SHIP_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setSavedShipsId(?int $id)
    {
        return $this->setData(self::SHIP_ID, $id);
    }
   
    /**
     * {@inheritdoc}
     */
    public function getDate(): string
    {
        return $this->getData(self::DATE);
    }

    /**
     * {@inheritdoc}
     */
    public function setDate(string $date)
    {
        return $this->setData(self::DATE, $date);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdBc(): int
    {
        return $this->getData(self::ID_BC);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdBc(int $idBc)
    {
        return $this->setData(self::ID_BC, $idBc);
    }

    /**
     * {@inheritdoc}
     */
    public function getNumCollect(): string
    {
        return $this->getData(self::NUM_COLLECT);
    }

    /**
     * {@inheritdoc}
     */
    public function setNumCollect(string $numCollect)
    {
        return $this->setData(self::NUM_COLLECT, $numCollect);
    }

    /**
     * {@inheritdoc}
     */
    public function getNumShip(): string
    {
        return $this->getData(self::NUM_SHIP);
    }

    /**
     * {@inheritdoc}
     */
    public function setNumShip(string $numShip)
    {
        return $this->setData(self::NUM_SHIP, $numShip);
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectFrom(): string
    {
        return $this->getData(self::COLLECT_FROM);
    }

    /**
     * {@inheritdoc}
     */
    public function setCollectFrom(string $collectFrom)
    {
        return $this->setData(self::COLLECT_FROM, $collectFrom);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdOrder(): int
    {
        return $this->getData(self::ID_ORDER);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdOrder(int $idOrder)
    {
        return $this->setData(self::ID_ORDER, $idOrder);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdMode(): int
    {
        return $this->getData(self::ID_MODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdMode(int $idMode)
    {
        return $this->setData(self::ID_MODE, $idMode);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdSender(): int
    {
        return $this->getData(self::ID_SENDER);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdSender(int $idSender)
    {
        return $this->setData(self::ID_SENDER, $idSender);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->getData(self::TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getKg(): float
    {
        return $this->getData(self::KG);
    }

    /**
     * {@inheritdoc}
     */
    public function setKg(float $kg)
    {
        return $this->setData(self::KG, $kg);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndsuredValue(): float
    {
        return $this->getData(self::INSURED_VALUE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndsuredValue(float $indsuredValue)
    {
        return $this->setData(self::INSURED_VALUE, $indsuredValue);
    }

    /**
     * {@inheritdoc}
     */
    public function getPackage(): int
    {
        return $this->getData(self::PACKAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPackage(int $package)
    {
        return $this->setData(self::PACKAGE, $package);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaybackVal(): float
    {
        return $this->getData(self::PAYBACK_VAL);
    }

    /**
     * {@inheritdoc}
     */
    public function setPaybackVal(float $paybackVal)
    {
        return $this->setData(self::PAYBACK_VAL, $paybackVal);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostalCode(): string
    {
        return $this->getData(self::POSTAL_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPostalCode(string $postalCode)
    {
        return $this->setData(self::POSTAL_CODE, $postalCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getModeShipName(): string
    {
        return $this->getData(self::MODE_SHIP_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setModeShipName(string $modeShipName)
    {
        return $this->setData(self::MODE_SHIP_NAME, $modeShipName);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(string $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdShipExpired(): int
    {
        return $this->getData(self::ID_SHIP_EXPIRED);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdShipExpired(int $idShipExpired)
    {
        return $this->setData(self::ID_SHIP_EXPIRED, $idShipExpired);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdGroup(): int
    {
        return $this->getData(self::ID_GROUP);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdGroup(int $idGroup)
    {
        return $this->setData(self::ID_GROUP, $idGroup);
    }

    /**
     * {@inheritdoc}
     */
    public function getNoteCollect(): string
    {
        return $this->getData(self::NOTE_COLLECT);
    }

    /**
     * {@inheritdoc}
     */
    public function setNoteCollect(string $noteCollect)
    {
        return $this->setData(self::NOTE_COLLECT, $noteCollect);
    }

    /**
     * {@inheritdoc}
     */
    public function getNoteDeliver(): string
    {
        return $this->getData(self::NOTE_DELIVER);
    }

    /**
     * {@inheritdoc}
     */
    public function setNoteDeliver(string $noteDeliver)
    {
        return $this->setData(self::NOTE_DELIVER, $noteDeliver);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsoCode(): string
    {
        return $this->getData(self::ISO_CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsoCode(string $isoCode)
    {
        return $this->setData(self::ISO_CODE, $isoCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getDevolution(): int
    {
        return $this->getData(self::DEVOLUTION);
    }

    /**
     * {@inheritdoc}
     */
    public function setDevolution(int $devolution)
    {
        return $this->setData(self::DEVOLUTION, $devolution);
    }

    /**
     * {@inheritdoc}
     */
    public function getDeliverSat(): int
    {
        return $this->getData(self::DELIVER_SAT);
    }

    /**
     * {@inheritdoc}
     */
    public function setDeliverSat(int $deliverSat)
    {
        return $this->setData(self::DELIVER_SAT, $deliverSat);
    }

    /**
     * {@inheritdoc}
     */
    public function getMailLabel(): int
    {
        return $this->getData(self::MAIL_LABEL);
    }

    /**
     * {@inheritdoc}
     */
    public function setMailLabel(int $mailLabel)
    {
        return $this->setData(self::MAIL_LABEL, $mailLabel);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescRef1(): string
    {
        return $this->getData(self::DESC_REF_1);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescRef1(string $descRef1)
    {
        return $this->setData(self::DESC_REF_1, $descRef1);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescRef2(): string
    {
        return $this->getData(self::DESC_REF_2);
    }

    /**
     * {@inheritdoc}
     */
    public function setDescRef2(string $descRef2)
    {
        return $this->setData(self::DESC_REF_2, $descRef2);
    }

    /**
     * {@inheritdoc}
     */
    public function getFromHour(): string
    {
        return $this->getData(self::FROM_HOUR);
    }

    /**
     * {@inheritdoc}
     */
    public function setFromHour(string $fromHour)
    {
        return $this->setData(self::FROM_HOUR, $fromHour);
    }

    /**
     * {@inheritdoc}
     */
    public function getToHour(): string
    {
        return $this->getData(self::TO_HOUR);
    }

    /**
     * {@inheritdoc}
     */
    public function setToHour(string $toHour)
    {
        return $this->setData(self::TO_HOUR, $toHour);
    }

    /**
     * {@inheritdoc}
     */
    public function getToMinute(): string
    {
        return $this->getData(self::TO_MINUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setToMinute(string $toMinute)
    {
        return $this->setData(self::TO_MINUTE, $toMinute);
    }

    /**
     * {@inheritdoc}
     */
    public function getFromMinute(): string
    {
        return $this->getData(self::FROM_MINUTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setFromMinute(string $fromMinute)
    {
        return $this->setData(self::FROM_MINUTE, $fromMinute);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderName(): string
    {
        return $this->getData(self::SENDER_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderName(string $senderName)
    {
        return $this->setData(self::SENDER_NAME, $senderName);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderContact(): string
    {
        return $this->getData(self::SENDER_CONTACT);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderContact(string $senderContact)
    {
        return $this->setData(self::SENDER_CONTACT, $senderContact);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderAddress(): string
    {
        return $this->getData(self::SENDER_ADDRESS);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderAddress(string $senderAddress)
    {
        return $this->setData(self::SENDER_ADDRESS, $senderAddress);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderPostCode(): string
    {
        return $this->getData(self::SENDER_POSTCODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderPostCode(string $senderPostCode)
    {
        return $this->setData(self::SENDER_POSTCODE, $senderPostCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderCity(): string
    {
        return $this->getData(self::SENDER_CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderCity(string $senderCity)
    {
        return $this->setData(self::SENDER_CITY, $senderCity);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderPhone(): string
    {
        return $this->getData(self::SENDER_PHONE);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderPhone(string $senderPhone)
    {
        return $this->setData(self::SENDER_PHONE, $senderPhone);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderCountry(): string
    {
        return $this->getData(self::SENDER_COUNTRY);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderCountry(string $senderCountry)
    {
        return $this->setData(self::SENDER_COUNTRY, $senderCountry);
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderEmail(): string
    {
        return $this->getData(self::SENDER_EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function setSenderEmail(string $senderEmail)
    {
        return $this->setData(self::SENDER_EMAIL, $senderEmail);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReceiverName(): string
    {
        return $this->getData(self::RECEIVER_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverName(string $receiverName)
    {
        return $this->setData(self::RECEIVER_NAME, $receiverName);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverContact(): string
    {
        return $this->getData(self::RECEIVER_CONTACT);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverContact(string $receiverContact)
    {
        return $this->setData(self::RECEIVER_CONTACT, $receiverContact);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverAddress(): string
    {
        return $this->getData(self::RECEIVER_ADDRESS);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverAddress(string $receiverAddress)
    {
        return $this->setData(self::RECEIVER_ADDRESS, $receiverAddress);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverPostCode(): string
    {
        return $this->getData(self::RECEIVER_POSTCODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverPostCode(string $receiverPostCode)
    {
        return $this->setData(self::RECEIVER_POSTCODE, $receiverPostCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverCity(): string
    {
        return $this->getData(self::RECEIVER_CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverCity(string $receiverCity)
    {
        return $this->setData(self::RECEIVER_CITY, $receiverCity);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverPhone(): string
    {
        return $this->getData(self::RECEIVER_PHONE);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverPhone(string $receiverPhone)
    {
        return $this->setData(self::RECEIVER_PHONE, $receiverPhone);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverPhone2(): string
    {
        return $this->getData(self::RECEIVER_PHONE2);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverPhone2(string $receiverPhone2)
    {
        return $this->setData(self::RECEIVER_PHONE2, $receiverPhone2);
    }


    /**
     * {@inheritdoc}
     */
    public function getReceiverCountry(): string
    {
        return $this->getData(self::RECEIVER_COUNTRY);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverCountry(string $receiverCountry)
    {
        return $this->setData(self::RECEIVER_COUNTRY, $receiverCountry);
    }

    /**
     * {@inheritdoc}
     */
    public function getReceiverEmail(): string
    {
        return $this->getData(self::RECEIVER_EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function setReceiverEmail(string $receiverEmail)
    {
        return $this->setData(self::RECEIVER_EMAIL, $receiverEmail);
    }

    /**
     * {@inheritdoc}
     */
    public function getCodigoCliente(): string
    {
        return $this->getData(self::CODIGO_CLIENTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setCodigoCliente(string $codigoCliente)
    {
        return $this->setData(self::CODIGO_CLIENTE, $codigoCliente);
    }

    /**
     * {@inheritdoc}
     */
    public function getOficinaEntrega(): string
    {
        return $this->getData(self::OFICINA_ENTREGA);
    }

    /**
     * {@inheritdoc}
     */
    public function setOficinaEntrega(string $oficinaEntrega)
    {
        return $this->setData(self::OFICINA_ENTREGA, $oficinaEntrega);
    }

     /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return parent::getData(self::CREATED_AT);
    }

     /**
     * @inheritDoc
     */
    public function setCreatedAt(string $created_at){
        return $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt():string
    {
        return parent::getData(self::UPDATED_AT);
    }

   /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updated_at){
        return $this->setData(self::UPDATED_AT, $updated_at);
    }

    /**
     * {@inheritdoc}
     */
    public function getWsEstadoTracking(): int
    {
        return $this->getData(self::WS_ESTADO_TRACKING);
    }

    /**
     * {@inheritdoc}
     */
    public function setWsEstadoTracking(int $wsEstadoTracking)
    {
        return $this->setData(self::WS_ESTADO_TRACKING, $wsEstadoTracking);
    }

    /**
     * @inheritDoc
     */
    public function getDeletedAt(): ?string
    {
        return parent::getData(self::DELETED_AT);
    }

   /**
     * @inheritDoc
     */
    public function setDeletedAt(?string $deleted_at){
        return $this->setData(self::DELETED_AT, $deleted_at);
    }

    /**
     * {@inheritdoc}
     */
    public function getModificacionAutomatica(): int
    {
        return $this->getData(self::MODIFICACION_AUTOMATICA);
    }

    /**
     * {@inheritdoc}
     */
    public function setModificacionAutomatica(int $modificacionAutomatica)
    {
        return $this->setData(self::MODIFICACION_AUTOMATICA, $modificacionAutomatica);
    }

    /**
     * {@inheritdoc}
     */
    public function getAtPortugal(): ?string
    {
        return $this->getData(self::AT_PORTUGAL);
    }

    /**
     * {@inheritdoc}
     */
    public function setAtPortugal(?string $atPortugal)
    {
        return $this->setData(self::AT_PORTUGAL, $atPortugal);
    }
}

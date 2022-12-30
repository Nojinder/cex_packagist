<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexSavedshipInterface
 * @api
 */
interface CexSavedshipInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the Date of the getter in snake case
     */
    const SHIP_ID                   = 'ship_id';
    const DATE                      = 'date';
    const NUM_COLLECT               = 'num_collect';
    const NUM_SHIP                  = 'num_ship';
    const COLLECT_FROM              = 'collect_from';
    const POSTAL_CODE               = 'postal_code';
    const ID_ORDER                  = 'id_order';
    const ID_MODE                   = 'id_mode';
    const ID_SENDER                 = 'id_sender';
    const TYPE                      = 'type';
    const KG                        = 'kg';
    const PACKAGE                   = 'package';
    const PAYBACK_VAL               = 'payback_val';
    const INSURED_VALUE             = 'insured_value';
    const ID_BC                     = 'id_bc';
    const MODE_SHIP_NAME            = 'mode_ship_name';
    const STATUS                    = 'status';
    const ID_SHIP_EXPIRED           = 'id_ship_expired';
    const ID_GROUP                  = 'id_group';
    const NOTE_COLLECT              = 'note_collect';
    const NOTE_DELIVER              = 'note_deliver';
    const ISO_CODE                  = 'iso_code';
    const DEVOLUTION                = 'devolution';
    const DELIVER_SAT               = 'deliver_sat';
    const MAIL_LABEL                = 'mail_label';
    const DESC_REF_1                = 'desc_ref_1';
    const DESC_REF_2                = 'desc_ref_2';
    const FROM_HOUR                 = 'from_hour';
    const FROM_MINUTE               = 'from_minute';
    const TO_HOUR                   = 'to_hour';
    const TO_MINUTE                 = 'to_minute';
    const SENDER_NAME               = 'sender_name';
    const SENDER_CONTACT            = 'sender_contact';
    const SENDER_ADDRESS            = 'sender_address';
    const SENDER_POSTCODE           = 'sender_postcode';
    const SENDER_CITY               = 'sender_city';
    const SENDER_PHONE              = 'sender_phone';
    const SENDER_COUNTRY            = 'sender_country';
    const SENDER_EMAIL              = 'sender_email';
    const RECEIVER_NAME             = 'receiver_name';
    const RECEIVER_CONTACT          = 'receiver_contact';
    const RECEIVER_ADDRESS          = 'receiver_address';
    const RECEIVER_POSTCODE         = 'receiver_postcode';
    const RECEIVER_CITY             = 'receiver_city';
    const RECEIVER_PHONE            = 'receiver_phone';
    const RECEIVER_PHONE2           = 'receiver_phone2';
    const RECEIVER_EMAIL            = 'receiver_email';
    const RECEIVER_COUNTRY          = 'receiver_country';
    const CODIGO_CLIENTE            = 'codigo_cliente';
    const OFICINA_ENTREGA           = 'oficina_entrega';
    const CREATED_AT                = 'created_at';
    const UPDATED_AT                = 'updated_at';
    const WS_ESTADO_TRACKING        = 'ws_estado_tracking';
    const DELETED_AT                = 'deleted_at';
    const MODIFICACION_AUTOMATICA   = 'modificacion_automatica';
    const AT_PORTUGAL               = 'at_portugal';
    /**#@-*/


    /**
     * @return int|null
     */
    public function getSavedShipsId(): ?int;

    /**
     * @param int|null $id
     * @return mixed
     */
    public function setSavedShipsId(?int $id);

    /**
     * @return string
     */
    public function getDate(): string;

    /**
     * @param string $date
     * @return mixed
     */
    public function setDate(string $date);

    /**
     * @return int
     */
    public function getIdBc(): int;

    /**
     * @param string $idBc
     * @return mixed
     */
    public function setIdBc(int $idBc);

    /**
     * @return string
     */
    public function getNumCollect(): string;

    /**
     * @param string $idCarrier
     * @return mixed
     */
    public function setNumCollect(string $numCollect);

    /**
     * @return string
     */
    public function getNumShip(): string;

    /**
     * @param string $idCarrier
     * @return mixed
     */
    public function setNumShip(string $numShip);

    /**
     * @return string
     */
    public function getCollectFrom(): string;

    /**
     * @param string $collectFrom
     * @return mixed
     */
    public function setCollectFrom(string $collectFrom);

    /**
     * @return string
     */
    public function getPostalCode(): string;

    /**
     * @param string $postalCode
     * @return mixed
     */
    public function setPostalCode(string $postalCode);

    /**
     * @return int
     */
    public function getIdOrder(): int;

    /**
     * @param int $idOrder
     * @return mixed
     */
    public function setIdOrder(int $idOrder);

    /**
     * @return int
     */
    public function getIdMode(): int;

    /**
     * @param int $idMode
     * @return mixed
     */
    public function setIdMode(int $idMode);

    /**
     * @return int
     */
    public function getIdSender(): int;

    /**
     * @param int $idSender
     * @return mixed
     */
    public function setIdSender(int $idSender);

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     * @return mixed
     */
    public function setType(string $type);

    /**
     * @return float
     */
    public function getKg(): float;

    /**
     * @param float $kg
     * @return mixed
     */
    public function setKg(float $kg);

    /**
     * @return int
     */
    public function getPackage(): int;

    /**
     * @param int $package
     * @return mixed
     */
    public function setPackage(int $package);

    /**
     * @return float
     */
    public function getPaybackVal(): float;

    /**
     * @param float $paybackVal
     * @return mixed
     */
    public function setPaybackVal(float $paybackVal);

    /**
     * @return float
     */
    public function getIndsuredValue(): float;

    /**
     * @param float $indsuredValue
     * @return mixed
     */
    public function setIndsuredValue(float $indsuredValue);

    /**
     * @return string
     */
    public function getModeShipName(): string;

    /**
     * @param string $modeShipName
     * @return mixed
     */
    public function setModeShipName(string $modeShipName);

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return mixed
     */
    public function setStatus(string $status);

    /**
     * @return int
     */
    public function getIdShipExpired(): int;

    /**
     * @param int $idShipExpired
     * @return mixed
     */
    public function setIdShipExpired(int $idShipExpired);

    /**
     * @return int
     */
    public function getIdGroup(): int;

    /**
     * @param int $idGroup
     * @return mixed
     */
    public function setIdGroup(int $idGroup);

    /**
     * @return string
     */
    public function getNoteCollect(): string;

    /**
     * @param string $noteCollect
     * @return mixed
     */
    public function setNoteCollect(string $noteCollect);

    /**
     * @return string
     */
    public function getNoteDeliver(): string;

    /**
     * @param string $noteDeliver
     * @return mixed
     */
    public function setNoteDeliver(string $noteDeliver);

    /**
     * @return string
     */
    public function getIsoCode(): string;

    /**
     * @param string $isoCode
     * @return mixed
     */
    public function setIsoCode(string $isoCode);

    /**
     * @return int
     */
    public function getDevolution(): int;

    /**
     * @param int $devolution
     * @return mixed
     */
    public function setDevolution(int $devolution);

    /**
     * @return int
     */
    public function getDeliverSat(): int;

    /**
     * @param int $deliverSat
     * @return mixed
     */
    public function setDeliverSat(int $deliverSat);

    /**
     * @return int
     */
    public function getMailLabel(): int;

    /**
     * @param int $mailLabel
     * @return mixed
     */
    public function setMailLabel(int $mailLabel);

    /**
     * @return string
     */
    public function getDescRef1(): string;

    /**
     * @param string $descRef1
     * @return mixed
     */
    public function setDescRef1(string $descRef1);

    /**
     * @return string
     */
    public function getDescRef2(): string;

    /**
     * @param string $descRef2
     * @return mixed
     */
    public function setDescRef2(string $descRef2);

    /**
     * @return string
     */
    public function getFromHour(): string;

    /**
     * @param string $fromHour
     * @return mixed
     */
    public function setFromHour(string $fromHour);

    /**
     * @return string
     */
    public function getFromMinute(): string;

    /**
     * @param string $fromMinute
     * @return mixed
     */
    public function setFromMinute(string $fromMinute);

    /**
     * @return string
     */
    public function getToMinute(): string;

    /**
     * @param string $toMinute
     * @return mixed
     */
    public function setToMinute(string $toMinute);

    /**
     * @return string
     */
    public function getToHour(): string;

    /**
     * @param string $toHour
     * @return mixed
     */
    public function setToHour(string $toHour);

    /**
     * @return string
     */
    public function getSenderName(): string;

    /**
     * @param string $senderName
     * @return mixed
     */
    public function setSenderName(string $senderName);

    /**
     * @return string
     */
    public function getSenderContact(): string;

    /**
     * @param string $senderContact
     * @return mixed
     */
    public function setSenderContact(string $senderContact);

    /**
     * @return string
     */
    public function getSenderAddress(): string;

    /**
     * @param string $senderAddress
     * @return mixed
     */
    public function setSenderAddress(string $senderAddress);

    /**
     * @return string
     */
    public function getSenderPostCode(): string;

    /**
     * @param string $senderPostCode
     * @return mixed
     */
    public function setSenderPostCode(string $senderPostCode);

    /**
     * @return string
     */
    public function getSenderCity(): string;

    /**
     * @param string $senderCity
     * @return mixed
     */
    public function setSenderCity(string $senderCity);

    /**
     * @return string
     */
    public function getSenderPhone(): string;

    /**
     * @param string $senderPhone
     * @return mixed
     */
    public function setSenderPhone(string $senderPhone);

    /**
     * @return string
     */
    public function getSenderCountry(): string;

    /**
     * @param string $senderCountry
     * @return mixed
     */
    public function setSenderCountry(string $senderCountry);

    /**
     * @return string
     */
    public function getSenderEmail(): string;

    /**
     * @param string $senderEmail
     * @return mixed
     */
    public function setSenderEmail(string $senderEmail);

     /**
     * @return string
     */
    public function getReceiverName(): string;

    /**
     * @param string $receiverName
     * @return mixed
     */
    public function setReceiverName(string $receiverName);

    /**
     * @return string
     */
    public function getReceiverContact(): string;

    /**
     * @param string $receiverContact
     * @return mixed
     */
    public function setReceiverContact(string $receiverContact);

    /**
     * @return string
     */
    public function getReceiverAddress(): string;

    /**
     * @param string $receiverAddress
     * @return mixed
     */
    public function setReceiverAddress(string $receiverAddress);

    /**
     * @return string
     */
    public function getReceiverPostCode(): string;

    /**
     * @param string $receiverPostCode
     * @return mixed
     */
    public function setReceiverPostCode(string $receiverPostCode);

    /**
     * @return string
     */
    public function getReceiverCity(): string;

    /**
     * @param string $receiverCity
     * @return mixed
     */
    public function setReceiverCity(string $receiverCity);

    /**
     * @return string
     */
    public function getReceiverPhone(): string;

    /**
     * @param string $receiverPhone
     * @return mixed
     */
    public function setReceiverPhone(string $receiverPhone);

    /**
     * @return string
     */
    public function getReceiverPhone2(): string;

    /**
     * @param string $receiverPhone2
     * @return mixed
     */
    public function setReceiverPhone2(string $receiverPhone2);

    /**
     * @return string
     */
    public function getReceiverCountry(): string;

    /**
     * @param string $receiverCountry
     * @return mixed
     */
    public function setReceiverCountry(string $receiverCountry);

    /**
     * @return string
     */
    public function getReceiverEmail(): string;

    /**
     * @param string $receiverEmail
     * @return mixed
     */
    public function setReceiverEmail(string $receiverEmail);

    /**
     * @return string
     */
    public function getCodigoCliente(): string;

    /**
     * @param string $codigoCliente
     * @return mixed
     */
    public function setCodigoCliente(string $codigoCliente);

    /**
     * @return string
     */
    public function getOficinaEntrega(): string;

    /**
     * @param string $oficinaEntrega
     * @return mixed
     */
    public function setOficinaEntrega(string $oficinaEntrega);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     * @return mixed
     */
    public function setCreatedAt(string $createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     * @return mixed
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * @return int
     */
    public function getWsEstadoTracking(): int;

    /**
     * @param int $wsEstadoTracking
     * @return mixed
     */
    public function setWsEstadoTracking(int $wsEstadoTracking);

    /**
     * @return string
     */
    public function getDeletedAt(): ?string;

    /**
     * @param string $deletedAt
     * @return mixed
     */
    public function setDeletedAt(?string $deletedAt);
    
    /**
     * @return int
     */
    public function getModificacionAutomatica(): int;

    /**
     * @param int $modificacionAutomatica
     * @return mixed
     */
    public function setModificacionAutomatica(int $modificacionAutomatica);

    /**
     * @return string
     */
    public function getAtPortugal(): ?string;

    /**
     * @param string $atPortugal
     * @return mixed
     */
public function setAtPortugal(?string $atPortugal);
}

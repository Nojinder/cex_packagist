<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexSavedsenderInterface
 * @api
 */

interface CexSavedsenderInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const SENDER_ID             = 'sender_id';
    const NAME                  = 'name';
    const ADDRESS               = 'address';
    const POST_CODE             = 'postcode';
    const CITY                  = 'city';
    const CONTACT               = 'contact';
    const PHONE                 = 'phone';
    const FROM_HOUR             = 'from_hour';
    const FROM_MINUTE           = 'from_minute';
    const TO_HOUR               = 'to_hour';
    const TO_MINUTE             = 'to_minute';
    const ISO_CODE_PAIS         = 'iso_code_pais';
    const EMAIL                 = 'email';
    const ID_COD_CLIENTE        = 'id_cod_cliente';
    /**#@-*/


    /**
     * @return int|null
     */
    public function getSenderId():?int;

    /**
     * @param int|null $senderId
     * @return void
     */
    public function setSenderId(?int $senderId);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @param string $address
     * @return void
     */
    public function setAddress(string $address);

    /**
     * @return string
     */
    public function getPostCode(): string;

    /**
     * @param string $postCode
     * @return void
     */
    public function setPostCode(string $postCode);

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param string $city
     * @return void
     */
    public function setCity(string $city);

    /**
     * @return string
     */
    public function getContact(): string;

    /**
     * @param string $contact
     * @return void
     */
    public function setContact(string $contact);

    /**
     * @return string
     */
    public function getPhone(): string;

    /**
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone);

    /**
     * @return int|null
     */
    public function getFromHour():?int;

    /**
     * @param int|null $fromHour
     * @return void
     */
    public function setFromHour(?int $fromHour);

    /**
     * @return int|null
     */
    public function getFromMinute():?int;

    /**
     * @param int|null $fromMinute
     * @return void
     */
    public function setFromMinute(?int $fromMinute);

    /**
     * @return int|null
     */
    public function getToHour():?int;

    /**
     * @param int|null $toHour
     * @return void
     */
    public function setToHour(?int $toHour);

    /**
     * @return int|null
     */
    public function getToMinute():?int;

    /**
     * @param int|null $toMinute
     * @return void
     */
    public function setToMinute(?int $toMinute);

    /**
     * @return string
     */
    public function getIsoCodePais(): string;

    /**
     * @param string $isoCodePais
     * @return void
     */
    public function setIsoCodePais(string $isoCodePais);

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email);

    /**
     * @return int|null
     */
    public function getIdCodCliente():?int;

    /**
     * @param int|null $idCodCliente
     * @return void
     */
    public function setIdCodCliente(?int $idCodCliente);
}

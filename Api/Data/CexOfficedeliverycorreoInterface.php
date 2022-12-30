<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexOfficedeliverycorreoInterface
 * @api
 */
interface CexOfficedeliverycorreoInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const OFFICE_DELIVERY_CORREO_ID     = 'officedeliverycorreo_id';
    const ID_CART                       = 'id_cart';
    const ID_CARRIER                    = 'id_carrier';
    const ID_CUSTOMER                   = 'id_customer';
    const CODIGO_OFICINA                = 'codigo_oficina';
    const TEXTO_OFICINA                 = 'texto_oficina';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getOfficeDeliveryCorreoId(): ?int;

    /**
     * @param int|null $officeDeliveryOfficeId
     * @return mixed
     */
    public function setOfficeDeliveryCorreoId(?int $officeDeliveryOfficeId);

    /**
     * @return int|null
     */
    public function getIdCart(): ?int;

    /**
     * @param int|null $idCart
     * @return mixed
     */
    public function setIdCart(?int $idCart);

    /**
     * @return string
     */
    public function getIdCarrier(): string;

    /**
     * @param string $idCarrier
     * @return mixed
     */
    public function setIdCarrier(string $idCarrier);

    /**
     * @return int|null
     */
    public function getIdCustomer(): ?int;

    /**
     * @param int|null $idCustomer
     * @return mixed
     */
    public function setIdCustomer(?int $idCustomer);

    /**
     * @return string
     */
    public function getCodigoOficina(): string;

    /**
     * @param string $codigoOficina
     * @return mixed
     */
    public function setCodigoOficina(string $codigoOficina);

    /**
     * @return string
     */
    public function getTextoOficina(): string;

    /**
     * @param string $textoOficina
     * @return mixed
     */
    public function setTextoOficina(string $textoOficina);

}


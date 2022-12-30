<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexSavedmodeshipInterface
 * @api
 */
interface CexSavedmodeshipInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const MODE_SHIPS_ID     = 'modeships_id';
    const NAME              = 'name';
    const ID_BC             = 'id_bc';
    const ID_CARRIER        = 'id_carrier';
    const CHECKED           = 'checked';
    const ID_CUSTOMER_CODE  = 'id_customer_code';
    const SHORT_NAME        = 'short_name';
    /**#@-*/


    /**
     * @return int|null
     */
    public function getModeShipsId(): ?int;

    /**
     * @param int|null $id
     * @return mixed
     */
    public function setModeShipsId(?int $id);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getIdBc(): string;

    /**
     * @param string $idBc
     * @return mixed
     */
    public function setIdBc(string $idBc);

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
     * @return int
     */
    public function getChecked(): int;

    /**
     * @param int $checked
     * @return mixed
     */
    public function setChecked(int $checked);

    /**
     * @return int
     */
    public function getIdCustomerCode(): int;

    /**
     * @param int $idCustomercode
     * @return mixed
     */
    public function setIdCustomerCode(int $idCustomercode);

    /**
     * @return string
     */
    public function getShortName(): string;

    /**
     * @param string $shortName
     * @return mixed
     */
    public function setShortName(string $shortName);

}

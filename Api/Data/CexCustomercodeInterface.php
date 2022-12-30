<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexCustomercodeInterface
 * @api
 */
interface CexCustomercodeInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CUSTOMER_CODE_ID              = 'customer_code_id';
    const CUSTOMER_CODE                 = 'customer_code';
    const CODE_DEMAND                   = 'code_demand';
    const ID_SHOP                       = 'id_shop';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getCustomerCodeId(): ?int;

    /**
     * @param int|null $customerCodeId
     * @return void
     */
    public function setCustomerCodeId(?int $customerCodeId);

    /**
     * @return string
     */
    public function getCustomerCode(): string;

    /**
     * @param string $customerCode
     * @return void
     */
    public function setCustomerCode(string $customerCode);

    /**
     * @return string
     */
    public function getCodeDemand(): string;

    /**
     * @param string $codeDemand
     * @return void
     */
    public function setCodeDemand(string $codeDemand);

    /**
     * @return int|null
     */
    public function getIdShop(): ?int;

    /**
     * @param int|null $idShop
     * @return void
     */
    public function setIdShop(?int $idShop);
}

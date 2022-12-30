<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexCustomeroptionInterface
 * @api
 */
interface CexCustomeroptionInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CUSTOMER_OPTIONS_ID     = 'customer_options_id';
    const CLAVE                   = 'clave';
    const VALOR                   = 'valor';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getCustomerOptionsId(): ?int;

    /**
     * @param int|null $customerOptionsId
     * @return mixed
     */
    public function setCustomerOptionsId(?int $customerOptionsId);  

    /**
     * @return string
     */
    public function getClave(): string;

    /**
     * @param string $clave
     * @return mixed
     */
    public function setClave(string $clave);

    /**
     * @return string
     */
    public function getValor(): string;

    /**
     * @param string $valor
     * @return mixed
     */
    public function setValor(string $valor);   
}

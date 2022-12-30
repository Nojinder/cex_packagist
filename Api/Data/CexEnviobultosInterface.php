<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexEnviobultosInterface
 * @api
 */
interface CexEnviobultosInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENVIOBULTOS_ID        = 'enviobultos_id';
    const ID_ORDER              = 'id_order';
    const NUM_COLLECT           = 'num_collect';
    const NUM_SHIP              = 'num_ship';
    const COD_UNICO_BULTO       = 'cod_unico_bulto';
    const ID_BULTO              = 'id_bulto';
    const FECHA                 = 'fecha';
    const DELETED_AT            = 'deleted_at';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getEnviobultosId():?int;

    /**
     * @param int|null $envioBultosId
     * @return void
     */
    public function setEnviobultosId(?int $envioBultosId);

    /**
     * @return int|null
     */
    public function getIdOrder():?int;

    /**
     * @param int|null $idOrder
     * @return void
     */
    public function setIdOrder(?int $idOrder);

    /**
     * @return string
     */
    public function getNumCollect(): string;

    /**
     * @param string $numCollect
     * @return void
     */
    public function setNumCollect(string $numCollect);

    /**
     * @return string
     */
    public function getNumShip(): string;

    /**
     * @param string $numShip
     * @return void
     */
    public function setNumShip(string $numShip);

    /**
     * @return string
     */
    public function getCodUnicoBulto(): string;

    /**
     * @param string $codUnicoBucle
     * @return void
     */
    public function setCodUnicoBulto(string $codUnicoBucle);

    /**
     * @return int|null
     */
    public function getIdBulto(): ?int;

    /**
     * @param int|null $idBulto
     * @return void
     */
    public function setIdBulto(?int $idBulto);

    /**
     * @return string
     */
    public function getFecha(): string;

    /**
     * @param string $fecha
     * @return void
     */
    public function setFecha(string $fecha);

    /**
     * @return string
     */
    public function getDeletedAt(): string;

    /**
     * @param string $deletedAt
     * @return void
     */
    public function setDeletedAt(string $deletedAt);
}

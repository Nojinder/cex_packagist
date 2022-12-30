<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexMigrationInterface
 * @api
 */
interface CexMigrationInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const MIGRATION_ID     = 'migration_id';
    const METODO_EJECUTADO = 'metodo_ejecutado';
    const CREATED_AT       = 'created_at';
    /**#@-*/

    /**
     * Return  migration ID.
     *
     * @return int Migration ID. Otherwise, null.
     */
    public function getMigrationId(): ?int;

    /**
     * Set the migration ID.
     *
     * @param int|null $id
     * @return void
     */
    public function setMigrationId(int $id);

    /**
     * Return el método ejecutado
     *
     * @return string Metodo ejecutado
     */
    public function getMetodoEjecutado(): string;

    /**
     * Set el método ejecutado
     *
     * @param string $metodoEjecutado
     * @return void
     */
    public function setMetodoEjecutado(string $metodoEjecutado);

    /**
     * Return the created_at timestamp
     *
     */
    public function getCreatedAt();

    /**
     * @param string $created_at
     * @return void
     */
    public function setCreatedAt(string $created_at);
}

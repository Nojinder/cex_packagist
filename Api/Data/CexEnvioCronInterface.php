<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;
/**
 * Interface CexEnvioCronInterface
 * @api
 */
interface CexEnvioCronInterface
{
    const ID_ENVIO_CRON     = 'id_envio_cron';
    const PETICION_ENVIO    = 'peticion_envio';
    const RESPUESTA_ENVIO   = 'respuesta_envio';
    const CODERROR          = 'codError';
    const DESCERROR         = 'descError';
    const CODCLIENTE        = 'codCliente';
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
    const DELETED_AT        = 'deleted_at';

    /**
     * @return int
     */
    public function getIdEnvioCron(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setIdEnvioCron(int $id);

    /**
     * @return string
     */
    public function getPeticionEnvio(): string;

    /**
     * @param string $peticion_envio
     * @return void
     */
    public function setPeticionEnvio(string $peticion_envio);

    /**
     * @return string
     */
    public function getRespuestaEnvio(): string;

    /**
     * @param string $respuesta_envio
     * @return void
     */
    public function setRespuestaEnvio(string $respuesta_envio);

     /**
     * @return int
     */
    public function getCodError(): int;

    /**
     * @param int $codError
     * @return void
     */
    public function setCodError(int $codError);

    /**
     * @return string
     */
    public function getDescError(): string;

    /**
     * @param string|null $descError
     * @return void
     */
    public function setDescError(?string $descError);

    /**
     * @return string
     */
    public function getCodCliente(): string;

    /**
     * @param string $codCliente
     * @return void
     */
    public function setCodCliente(string $codCliente);

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $created_at
     * @return void
     */
    public function setCreatedAt(string $created_at);

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updated_at
     * @return void
     */
    public function setUpdatedAt(string $updated_at);

    /**
     * @return string
     */
    public function getDeletedAt(): string;

    /**
     * @param string $deleted_at
     * @return void
     */
    public function setDeletedAt(string $deleted_at);
}

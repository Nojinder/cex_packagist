<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;
/**
 * Interface CexRespuestaCronInterface
 * @api
 */

interface CexRespuestaCronInterface
{

    const ID_RESPUESTA_CRON     = 'id_respuesta_cron';
    const NENVIOCLIENTE         = 'nEnvioCliente';
    const REFERENCIA            = 'referencia';
    const CODIGOINCIDENCIA      = 'codigoIncidencia';
    const DESCRIPCIONINCIDENCIA = 'descripcionIncidencia';
    const CODIGOESTADO          = 'codigoEstado';
    const DESCRIPCIONESTADO     = 'descripcionEstado';
    const CODCLIENTE            = 'codCliente';
    const ESTADOANTIGUO         = 'estadoAntiguo';
    const CREATED_AT            = 'created_at';
    const UPDATED_AT            = 'updated_at';
    const DELETED_AT            = 'deleted_at';
    const ID_ENVIO_CRON         = 'id_envio_cron';

    /**
     * @return int
     */
    public function getIdRespuestaCron(): int;

    /**
     * @param int $id
     * @return void
     */
    public function setIdRespuestaCron(int $id);

    /**
     * @return string
     */
    public function getNEnvio(): string;

    /**
     * @param string $nEnvioCliente
     * @return void
     */
    public function setNEnvio(string $nEnvioCliente);

    /**
     * @return string
     */
    public function getReferencia(): string;

    /**
     * @param string $referencia
     * @return void
     */
    public function setReferencia(string $referencia);

     /**
     * @return int
     */
    public function getCodIncidencia(): int;

    /**
     * @param int|null $codigoIncidencia
     * @return void
     */
    public function setCodIncidencia(?int $codigoIncidencia);

    /**
     * @return string
     */
    public function getDescIncidencia(): string;

    /**
     * @param string|null $descripcionIncidencia
     * @return void
     */
    public function setDescIncidencia(?string $descripcionIncidencia);

    /**
     * @return int
     */
    public function getCodEstado(): int;

    /**
     * @param int $codigoEstado
     * @return void
     */
    public function setCodEstado(int $codigoEstado);


    /**
     * @return string
     */
    public function getDescEstado(): string;

    /**
     * @param string $descripcionEstado
     * @return void
     */
    public function setDescEstado(string $descripcionEstado);

     /**
     * @return string
     */
    public function getcodCliente(): string;

    /**
     * @param string $codCliente
     * @return void
     */
    public function setcodCliente(string $codCliente);

     /**
     * @return int
     */
    public function getEstadoAntiguo(): int;

    /**
     * @param int $estadoAntiguo
     * @return void
     */
    public function setEstadoAntiguo(int $estadoAntiguo);

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

     /**
     * @return int
     */
    public function getIdEnvioCron(): int;

    /**
     * @param int $id_envio_cron
     * @return void
     */
    public function setIdEnvioCron(int $id_envio_cron);
}

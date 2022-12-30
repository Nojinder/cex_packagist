<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

/**
 * Interface CexHistoryInterface
 * @api
 */
interface CexHistoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const HISTORY_ID                    = 'history_id';
    const ID_ORDER                      = 'id_order';
    const NUM_COLLECT                   = 'num_collect';
    const TYPE                          = 'type';
    const NUM_SHIP                      = 'num_ship';
    const RESULTADO                     = 'resultado';
    const MENSAJE_RETORNO               = 'mensaje_retorno';
    const CODIGO_RETORNO                = 'codigo_retorno';
    const ENVIO_WS                      = 'envio_ws';
    const RESPUESTA_WS                  = 'respuesta_ws';
    const FECHA                         = 'fecha';
    const FECHA_RECOGIDA                = 'fecha_recogida';
    const HORA_RECOGIDA_DESDE           = 'hora_recogida_desde';
    const HORA_RECOGIDA_HASTA           = 'hora_recogida_hasta';
    const ID_BC_WS                      = 'id_bc_ws';
    const MODE_SHIP_NAME_WS             = 'mode_ship_name_ws';
    /**#@-*/

    /**
     * @return int|null
     */
    public function getHistoryId(): ?int;

    /**
     * @param int|null $historyId
     * @return mixed
     */
    public function setHistoryId(?int $historyId);

    /**
     * @return int|null
     */
    public function getIdOrder(): ?int;

    /**
     * @param int|null $idOrder
     * @return mixed
     */
    public function setIdOrder(?int $idOrder);

    /**
     * @return string
     */
    public function getNumCollect(): string;

    /**
     * @param string $numCollect
     * @return mixed
     */
    public function setNumCollect(string $numCollect);

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
     * @return string|null
     */
    public function getNumShip(): ?string;

    /**
     * @param string|null $numShip
     * @return mixed
     */
    public function setNumShip(?string $numShip);

    /**
     * @return string
     */
    public function getResultado(): string;

    /**
     * @param string $resultado
     * @return mixed
     */
    public function setResultado(string $resultado);

    /**
     * @return string
     */
    public function getMensajeRetorno(): ?string;

    /**
     * @param string $mensajeRetorno
     * @return mixed
     */
    public function setMensajeRetorno(?string $mensajeRetorno);

    /**
     * @return int|null
     */
    public function getCodigoRetorno(): ?int;

    /**
     * @param int|null $codigoRetorno
     * @return mixed
     */
    public function setCodigoRetorno(?int $codigoRetorno);

    /**
     * @return string
     */
    public function getEnvioWs(): string;

    /**
     * @param string $envioWs
     * @return mixed
     */
    public function setEnvioWs(string $envioWs);

    /**
     * @return string
     */
    public function getRespuestaWs(): string;

    /**
     * @param string $respuestaWs
     * @return mixed
     */
    public function setRespuestaWs(string $respuestaWs);

    /**
     * @return string
     */
    public function getFecha(): string;

    /**
     * @param string $fecha
     * @return mixed
     */
    public function setFecha(string $fecha);

    /**
     * @return string
     */
    public function getFechaRecogida(): ?string;

    /**
     * @param string $fechaRecogida
     * @return mixed
     */
    public function setFechaRecogida(?string $fechaRecogida);

    /**
     * @return string
     */
    public function getHoraRecogidaDesde(): ?string;

    /**
     * @param string $horaRecogidaDesde
     * @return mixed
     */
    public function setHoraRecogidaDesde(?string $horaRecogidaDesde);

    /**
     * @return string
     */
    public function getHoraRecogidaHasta(): ?string;

    /**
     * @param string $horaRecogidaHasta
     * @return mixed
     */
    public function setHoraRecogidaHasta(?string $horaRecogidaHasta);

    /**
     * @return int|null
     */
    public function getIdBcWs(): ?int;

    /**
     * @param int|null $idBcWs
     * @return mixed
     */
    public function setIdBcWs(?int $idBcWs);

    /**
     * @return string
     */
    public function getModeShipNameWs(): ?string;

    /**
     * @param string $modeShipNameWs
     * @return mixed
     */
    public function setModeShipNameWs(?string $modeShipNameWs);


}

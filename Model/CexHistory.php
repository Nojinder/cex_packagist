<?php
namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

Class CexHistory extends AbstractExtensibleModel
              implements IdentityInterface,CexHistoryInterface
{
    const CACHE_TAG             = "correosexpress_registrodeenvios_cexhistory";
    protected $_cacheTag        = "correosexpress_registrodeenvios_cexhistory";
    protected $_eventPrefix     = "correosexpress_registrodeenvios_cexhistory";


    protected function _construct(){
        $this->_init('CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexHistory');
    }

    /**
     * @return string[]
     */
    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues(){
        $values = [];
        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getHistoryId(): ?int
    {
        return $this->getData(self::HISTORY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setHistoryId(?int $historyId)
    {
        return $this->setData(self::HISTORY_ID, $historyId);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdOrder(): ?int
    {
        return $this->getData(self::ID_ORDER);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdOrder(?int $idOrder)
    {
        return $this->setData(self::ID_ORDER, $idOrder);
    }

    /**
     * {@inheritdoc}
     */
    public function getNumCollect(): string
    {
        return $this->getData(self::NUM_COLLECT);
    }

    /**
     * {@inheritdoc}
     */
    public function setNumCollect(string $numCollect)
    {
        return $this->setData(self::NUM_COLLECT, $numCollect);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->getData(self::TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getNumShip(): ?string
    {
        return $this->getData(self::NUM_SHIP);
    }

    /**
     * {@inheritdoc}
     */
    public function setNumShip(?string $numShip)
    {
        return $this->setData(self::NUM_SHIP, $numShip);
    }

    /**
     * {@inheritdoc}
     */
    public function getResultado(): string
    {
        return $this->getData(self::RESULTADO);
    }

    /**
     * {@inheritdoc}
     */
    public function setResultado(string $resultado)
    {
        return $this->setData(self::RESULTADO, $resultado);
    }

    /**
     * {@inheritdoc}
     */
    public function getMensajeRetorno(): ?string
    {
        return $this->getData(self::MENSAJE_RETORNO);
    }

    /**
     * {@inheritdoc}
     */
    public function setMensajeRetorno(?string $mensajeRetorno)
    {
        return $this->setData(self::MENSAJE_RETORNO, $mensajeRetorno);
    }

    /**
     * {@inheritdoc}
     */
    public function getCodigoRetorno(): ?int
    {
        return $this->getData(self::CODIGO_RETORNO);
    }

    /**
     * {@inheritdoc}
     */
    public function setCodigoRetorno(?int $codigoRetorno)
    {
        return $this->setData(self::CODIGO_RETORNO, $codigoRetorno);
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvioWs(): string
    {
        return $this->getData(self::ENVIO_WS);
    }

    /**
     * {@inheritdoc}
     */
    public function setEnvioWs(string $envioWs)
    {
        return $this->setData(self::ENVIO_WS, $envioWs);
    }

    /**
     * {@inheritdoc}
     */
    public function getRespuestaWs(): string
    {
        return $this->getData(self::RESPUESTA_WS);
    }

    /**
     * {@inheritdoc}
     */
    public function setRespuestaWs(string $respuestaWs)
    {
        return $this->setData(self::RESPUESTA_WS, $respuestaWs);
    }

    /**
     * {@inheritdoc}
     */
    public function getFecha(): string
    {
        return $this->getData(self::FECHA);
    }

    /**
     * {@inheritdoc}
     */
    public function setFecha(string $fecha)
    {
        return $this->setData(self::FECHA, $fecha);
    }

    /**
     * {@inheritdoc}
     */
    public function getFechaRecogida(): ?string
    {
        return $this->getData(self::FECHA_RECOGIDA);
    }

    /**
     * {@inheritdoc}
     */
    public function setFechaRecogida(?string $fechaRecogida)
    {
        return $this->setData(self::FECHA_RECOGIDA, $fechaRecogida);
    }

    /**
     * {@inheritdoc}
     */
    public function getHoraRecogidaDesde(): ?string
    {
        return $this->getData(self::HORA_RECOGIDA_DESDE);
    }

    /**
     * {@inheritdoc}
     */
    public function setHoraRecogidaDesde(?string $horaRecogidaDesde)
    {
        return $this->setData(self::HORA_RECOGIDA_DESDE, $horaRecogidaDesde);
    }

    /**
     * {@inheritdoc}
     */
    public function getHoraRecogidaHasta(): ?string
    {
        return $this->getData(self::HORA_RECOGIDA_HASTA);
    }

    /**
     * {@inheritdoc}
     */
    public function setHoraRecogidaHasta(?string $horaRecogidaHasta)
    {
        return $this->setData(self::HORA_RECOGIDA_HASTA, $horaRecogidaHasta);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdBcWs(): ?int
    {
        return $this->getData(self::ID_BC_WS);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdBcWs(?int $idBcWs)
    {
        return $this->setData(self::ID_BC_WS, $idBcWs);
    }

    /**
     * {@inheritdoc}
     */
    public function getModeShipNameWs(): ?string
    {
        return $this->getData(self::MODE_SHIP_NAME_WS);
    }

    /**
     * {@inheritdoc}
     */
    public function setModeShipNameWs(?string $modeShipNameWs)
    {
        return $this->setData(self::MODE_SHIP_NAME_WS, $modeShipNameWs);
    }
}

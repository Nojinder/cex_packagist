<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface;

class CexRespuestaCron extends AbstractExtensibleModel implements CexRespuestaCronInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\CexRespuestaCron::class);
    }

     /**
     * @inheritDoc
     */
    public function getIdRespuestaCron(): int
    {
        return parent::getData(self::ID_RESPUESTA_CRON);
    }

     /**
     * @inheritDoc
     */
    public function setIdRespuestaCron(int $id){
        return $this->setData(self::ID_RESPUESTA_CRON, $id);
    }

    /**
     * @inheritDoc
     */
    public function getNEnvio(): string
    {
        return parent::getData(self::NENVIOCLIENTE);
    }

    /**
     * @inheritDoc
     */
    public function setNEnvio(string $nEnvioCliente){
        return $this->setData(self::NENVIOCLIENTE, $nEnvioCliente);
    }

     /**
     * @inheritDoc
     */
    public function getReferencia(): string
    {
        return parent::getData(self::REFERENCIA);
    }

     /**
     * @inheritDoc
     */
    public function setReferencia(string $referencia){
        return $this->setData(self::REFERENCIA, $referencia);
    }

     /**
     * @inheritDoc
     */
    public function getCodIncidencia(): int
    {
        return parent::getData(self::CODIGOINCIDENCIA);
    }

    /**
     * @inheritDoc
     */
    public function setCodIncidencia(?int $codigoIncidencia){
        return $this->setData(self::CODIGOINCIDENCIA, $codigoIncidencia);
    }

    /**
     * @inheritDoc
     */
    public function getDescIncidencia(): string
    {
        return parent::getData(self::DESCRIPCIONINCIDENCIA);
    }

    /**
     * @inheritDoc
     */
    public function setDescIncidencia(?string $descripcionIncidencia){
        return $this->setData(self::DESCRIPCIONINCIDENCIA, $descripcionIncidencia);
    }

     /**
     * @inheritDoc
     */
    public function getCodEstado(): int
    {
        return parent::getData(self::CODIGOESTADO);
    }

    /**
     * @inheritDoc
     */
    public function setCodEstado(int $codigoEstado){
        return $this->setData(self::CODIGOESTADO, $codigoEstado);
    }

 /**
     * @inheritDoc
     */
    public function getDescEstado(): string
    {
        return parent::getData(self::DESCRIPCIONESTADO);
    }

    /**
     * @inheritDoc
     */
    public function setDescEstado(string $descripcionEstado){
        return $this->setData(self::DESCRIPCIONESTADO, $descripcionEstado);
    }

 /**
     * @inheritDoc
     */
    public function getcodCliente(): string
    {
        return parent::getData(self::CODCLIENTE);
    }

    /**
     * @inheritDoc
     */
    public function setcodCliente(string $codCliente){
        return $this->setData(self::CODCLIENTE, $codCliente);
    }

 /**
     * @inheritDoc
     */
    public function getEstadoAntiguo(): int
    {
        return parent::getData(self::ESTADOANTIGUO);
    }

    /**
     * @inheritDoc
     */
    public function setEstadoAntiguo(int $estadoAntiguo){
        return $this->setData(self::ESTADOANTIGUO, $estadoAntiguo);
    }

     /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return parent::getData(self::CREATED_AT);
    }

     /**
     * @inheritDoc
     */
    public function setCreatedAt(string $created_at){
        return $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string{
        return parent::getData(self::UPDATED_AT);
    }

   /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updated_at){
        return $this->setData(self::UPDATED_AT, $updated_at);
    }

  /**
     * @inheritDoc
     */
    public function getDeletedAt(): string
    {
        return parent::getData(self::DELETED_AT);
    }

   /**
     * @inheritDoc
     */
    public function setDeletedAt(string $deleted_at){
        return $this->setData(self::DELETED_AT, $deleted_at);
    }

 /**
     * @inheritDoc
     */
    public function getIdEnvioCron(): int{
        return parent::getData(self::ID_ENVIO_CRON);
    }

    /**
     * @inheritDoc
     */
    public function setIdEnvioCron(int $id_envio_cron){
        return $this->setData(self::ID_ENVIO_CRON, $id_envio_cron);
    }
    
}

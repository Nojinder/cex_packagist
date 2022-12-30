<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface;

class CexEnvioCron extends AbstractExtensibleModel implements CexEnvioCronInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\CexEnvioCron::class);
    }

     /**
     * @inheritDoc
     */
    public function getIdEnvioCron(): int
    {
        return parent::getData(self::ID_ENVIO_CRON);
    }

     /**
     * @inheritDoc
     */
    public function setIdEnvioCron(int $id)
    {
        return $this->setData(self::ID_ENVIO_CRON, $id);
    }

    /**
     * @inheritDoc
     */
    public function getPeticionEnvio(): string
    {
        return parent::getData(self::PETICION_ENVIO);
    }

    /**
     * @inheritDoc
     */
    public function setPeticionEnvio(string $peticion_envio){
        return $this->setData(self::PETICION_ENVIO, $peticion_envio);
    }

     /**
     * @inheritDoc
     */
    public function getRespuestaEnvio(): string
    {
        return parent::getData(self::RESPUESTA_ENVIO);
    }

     /**
     * @inheritDoc
     */
    public function setRespuestaEnvio(string $respuesta_envio){
        return $this->setData(self::RESPUESTA_ENVIO, $respuesta_envio);
    }

     /**
     * @inheritDoc
     */
    public function getCodError(): int
    {
        return parent::getData(self::CODERROR);
    }

    /**
     * @inheritDoc
     */
    public function setCodError(int $codError){
        return $this->setData(self::CODERROR, $codError);
    }

    /**
     * @inheritDoc
     */
    public function getDescError(): string
    {
        return parent::getData(self::DESCERROR);
    }

    /**
     * @inheritDoc
     */
    public function setDescError(?string $descError){
        return $this->setData(self::DESCERROR, $descError);
    }

     /**
     * @inheritDoc
     */
    public function getCodCliente(): string
    {
        return parent::getData(self::CODCLIENTE);
    }

    /**
     * @inheritDoc
     */
    public function setCodCliente(string $codCliente){
        return $this->setData(self::CODCLIENTE, $codCliente);
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
    public function getUpdatedAt():string
    {
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
}

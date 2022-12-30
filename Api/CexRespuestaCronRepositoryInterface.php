<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface;

interface CexRespuestaCronRepositoryInterface
{
    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexRespuestaCronInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface $cexRespuestaCron
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface
     */
    public function save(CexRespuestaCronInterface $cexRespuestaCron): CexRespuestaCronInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface $cexRespuestaCron
     * @return void
     */
   public function delete(CexRespuestaCronInterface $cexRespuestaCron);

   /**
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $id): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronSearchResultsInterface
     */
   public function getList(SearchCriteriaInterface $searchCriteria): Data\CexRespuestaCronSearchResultsInterface;
}

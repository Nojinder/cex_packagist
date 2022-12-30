<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface;
/**
 * @api
 */
interface CexEnvioCronRepositoryInterface
{
    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexEnvioCronInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface $cexEnvioCron
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface
     */
    public function save(CexEnvioCronInterface $cexEnvioCron): CexEnvioCronInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface $cexEnvioCron
     * @return void
     */
   public function delete(CexEnvioCronInterface $cexEnvioCron);

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
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronSearchResultsInterface
     */
   public function getList(SearchCriteriaInterface $searchCriteria): Data\CexEnvioCronSearchResultsInterface;
}

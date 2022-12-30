<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipSearchResultsInterface;

/**
 * @api
 */
interface CexSavedmodeshipRepositoryInterface
{
    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexSavedmodeshipInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface $cexSavedmodeship
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface
     */
    public function save(CexSavedmodeshipInterface $cexSavedmodeship): CexSavedmodeshipInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface $cexSavedmodeship
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexSavedmodeshipInterface $cexSavedmodeship): bool;

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
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexSavedmodeshipSearchResultsInterface;
}

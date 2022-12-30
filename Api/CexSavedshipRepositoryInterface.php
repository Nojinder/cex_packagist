<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipSearchResultsInterface;

/**
 * @api
 */
interface CexSavedshipRepositoryInterface
{
    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexSavedshipInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface $cexSavedship
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface
     */
    public function save(CexSavedshipInterface $cexSavedship): CexSavedshipInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface $cexSavedship
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexSavedshipInterface $cexSavedship): bool;

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
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexSavedshipSearchResultsInterface;
}

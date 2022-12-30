<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistorySearchResultsInterface;

/**
 * @api
 */
interface CexHistoryRepositoryInterface
{
    /**
     * @param int $historyId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $historyId): CexHistoryInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface $cexHistory
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface
     */
    public function save(CexHistoryInterface $cexHistory): CexHistoryInterface;


    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface $cexHistory
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexHistoryInterface $cexHistory): bool;

    /**
     * @param int $historyId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $historyId): bool;


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexHistorySearchResultsInterface;

}

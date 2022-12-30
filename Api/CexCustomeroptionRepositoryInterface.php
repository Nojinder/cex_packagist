<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionSearchResultsInterface;

/**
 * @api
 */
interface CexCustomeroptionRepositoryInterface
{
    /**
     * @param int $customeroptionId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $customeroptionId): CexCustomeroptionInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface $cexCustomeroption
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface
     */
    public function save(CexCustomeroptionInterface $cexCustomeroption): CexCustomeroptionInterface;


    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface $cexCustomeroption
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexCustomeroptionInterface $cexCustomeroption): bool;

    /**
     * @param int $customeroptionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $customeroptionId): bool;


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexCustomeroptionSearchResultsInterface;

}

<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeSearchResultsInterface;

/**
 * @api
 */
interface CexCustomercodeRepositoryInterface
{
    /**
     * @param int $customerCodeId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $customerCodeId): CexCustomercodeInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface $customer
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface
     */
    public function save(CexCustomercodeInterface $customer): CexCustomercodeInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface $customer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexCustomercodeInterface $customer): bool;

    /**
     * @param int $customerCodeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $customerCodeId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexCustomercodeSearchResultsInterface;

}

<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 */
interface CexSavedsenderRepositoryInterface
{
    /**
     * @param int $senderId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $senderId): cexSavedsenderInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface $savedsender
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface
     */
    public function save(CexSavedsenderInterface $savedsender): CexSavedsenderInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface $savedsender
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexSavedsenderInterface $savedsender): bool;

    /**
     * @param int $senderId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $senderId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexSavedsenderSearchResultsInterface;


}

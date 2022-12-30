<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationSearchResultsInterface;

/**
 * @api
 */
interface CexMigrationRepositoryInterface
{
    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexMigrationInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface $cexMigration
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface
     */
    public function save(CexMigrationInterface $cexMigration): CexMigrationInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface $cexMigration
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
   public function delete(CexMigrationInterface $cexMigration): bool;

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
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationSearchResultsInterface
     */
   public function getList(SearchCriteriaInterface $searchCriteria): CexMigrationSearchResultsInterface;
}

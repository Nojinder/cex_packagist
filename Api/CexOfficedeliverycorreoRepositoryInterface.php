<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoSearchResultsInterface;

/**
 * @api
 */
interface CexOfficedeliverycorreoRepositoryInterface
{
    /**
     * @param int $officeDeliveryCorreoId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $officeDeliveryCorreoId): CexOfficedeliverycorreoInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface $cexOfficedeliverycorreo
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface
     */
    public function save(CexOfficedeliverycorreoInterface $cexOfficedeliverycorreo): CexOfficedeliverycorreoInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface $cexOfficeDeliveryCorreo
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexOfficedeliverycorreoInterface $cexOfficeDeliveryCorreo): bool;

    /**
     * @param int $officeDeliveryCorreoId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $officeDeliveryCorreoId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexOfficedeliverycorreoSearchResultsInterface;
}

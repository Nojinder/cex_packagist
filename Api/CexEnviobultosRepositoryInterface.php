<?php

namespace CorreosExpress\RegistroDeEnvios\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosSearchResultsInterface;

/**
 * @api
 */
interface CexEnviobultosRepositoryInterface
{
    /**
     * @param int $envioBultosId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $envioBultosId): CexEnviobultosInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface $envioBultos
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface
     */
    public function save(CexEnviobultosInterface $envioBultos):CexEnviobultosInterface;

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface $envioBultos
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexEnviobultosInterface $envioBultos): bool;

    /**
     * @param int $envioBultosId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $envioBultosId): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria):CexEnviobultosSearchResultsInterface;
}

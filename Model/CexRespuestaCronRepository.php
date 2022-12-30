<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\CexRespuestaCronRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexRespuestaCron;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexRespuestaCron\CollectionFactory;

class CexRespuestaCronRepository implements CexRespuestaCronRepositoryInterface
{
    /**
     * @var CexRespuestaCronFactory
     */
    private $cexRespuestaCronFactory;

    /**
     * @var CexRespuestaCron
     */
    private $cexRespuestaCronResource;

    /**
     * @var CexRespuestaCronCollectionFactory
     */
    private $cexRespuestaCronCollectionFactory;

    /**
     * @var CexRespuestaCronSearchResultsInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        CexRespuestaCronFactory $cexRespuestaCronFactory,
        CexRespuestaCron $cexRespuestaCronResource,
        CollectionFactory $cexRespuestaCronCollectionFactory,
        CexRespuestaCronSearchResultsInterfaceFactory $cexRespuestaCronSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->cexRespuestaCronFactory              = $cexRespuestaCronFactory;
        $this->cexRespuestaCronResource             = $cexRespuestaCronResource;
        $this->cexRespuestaCronCollectionFactory    = $cexRespuestaCronCollectionFactory;
        $this->searchResultFactory                  = $cexRespuestaCronSearchResultInterfaceFactory;
        $this->collectionProcessor                  = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface
    {
        $cexRespuestaCron = $this->cexRespuestaCronFactory->create();
        $this->cexRespuestaCronResource->load($cexRespuestaCron, $id);
        if (!$cexRespuestaCron->getId()) {
            throw new NoSuchEntityException(__('Unable to find CexRespuestaCron with ID "%1"', $id));
        }
        return $cexRespuestaCron;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface $cexRespuestaCron
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CexRespuestaCronInterface $cexRespuestaCron): \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface
    {
        $this->cexRespuestaCronResource->save($cexRespuestaCron);
        return $cexRespuestaCron;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface $cexRespuestaCron
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexRespuestaCronInterface $cexRespuestaCron): bool
    {
        try {
            $this->cexRespuestaCronResource->delete($cexRespuestaCron);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
        return true;
    }

     /**
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $id): bool
    {
        try {
            $this->cexRespuestaCronResource->delete($this->getById($id));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $id)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronSearchResultsInterface
    {
        $collection = $this->cexRespuestaCronCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

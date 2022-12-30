<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexHistory\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexHistory;
use CorreosExpress\RegistroDeEnvios\Api\CexHistoryRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistorySearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistorySearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexHistoryRepository implements CexHistoryRepositoryInterface
{
    /**
     * @var CexHistoryFactory
     */
    private $cexHistoryFactory;

    /**
     * @var CexHistory
     */
    private $cexhistoryResource;

    /**
     * @var CexHistorySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionFactory
     */
    private $cexHistoryCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        CexHistoryFactory $cexHistoryFactory,
        CexHistory $cexHistoryResource,
        CollectionFactory $cexHistoryCollectionFactory,
        CexHistorySearchResultsInterfaceFactory $cexHistorySearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexHistoryFactory            = $cexHistoryFactory;
        $this->cexhistoryResource           = $cexHistoryResource;
        $this->cexHistoryCollectionFactory  = $cexHistoryCollectionFactory;
        $this->searchResultsFactory         = $cexHistorySearchResultsInterfaceFactory;
        $this->collectionProcessor          = $collectionProcessor;
    }

    /**
     * @param int $historyId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $historyId): CexHistoryInterface
    {
        $cexHistory = $this->cexHistoryFactory->create();
        $this->cexhistoryResource->load($cexHistory, $historyId);
        if(!$cexHistory->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexHistory with id: "%1"', $historyId));
        }
        return $cexHistory;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface $cexHistory
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface
     */
    public function save(CexHistoryInterface $cexHistory): CexHistoryInterface
    {
        $this->cexhistoryResource->save($cexHistory);
        return $cexHistory;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface $cexHistory
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexHistoryInterface $cexHistory): bool
    {
        try {
            $this->cexhistoryResource->delete($cexHistory);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $cexHistory)
            );
        }
        return true;
    }

    /**
     * @param int $historyId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $historyId): bool
    {
        try {
            $this->cexhistoryResource->delete($this->getById($historyId));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $historyId)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexHistorySearchResultsInterface
    {
        $collection = $this->cexHistoryCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

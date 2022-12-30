<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\CexMigrationRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexMigration\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexMigration;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexMigrationRepository implements CexMigrationRepositoryInterface
{
    /**
     * @var CexMigrationFactory
     */
    private $cexMigrationFactory;
    
    /**
     * @var CexMigration
     */
    private $cexMigrationResource;

    /**
     * @var CollectionFactory
     */
    private $cexMigrationCollectionFactory;

    /**
     * @var CexMigrationSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        CexMigrationFactory $cexMigrationFactory,
        CexMigration $cexMigrationResource,
        CollectionFactory $cexMigrationCollectionFactory,
        CexMigrationSearchResultsInterfaceFactory $cexMigrationSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexMigrationFactory              = $cexMigrationFactory;
        $this->cexMigrationResource             = $cexMigrationResource;
        $this->cexMigrationCollectionFactory    = $cexMigrationCollectionFactory;
        $this->searchResultsFactory             = $cexMigrationSearchResultsInterfaceFactory;
        $this->collectionProcessor              = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexMigrationInterface
    {
        $cexMigration = $this->cexMigrationFactory->create();
        $this->cexMigrationResource->load($cexMigration, $id);
        if(!$cexMigration->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexMigration with id: "%1"', $id));
        }
        return $cexMigration;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface $cexMigration
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface
     */
    public function save(CexMigrationInterface $cexMigration): CexMigrationInterface
    {
      $this->cexMigrationResource->save($cexMigration);
      return $cexMigration;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface $cexMigration
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexMigrationInterface $cexMigration): bool
    {
        try {
            $this->cexMigrationResource->delete($cexMigration);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $cexMigration)
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
            $this->cexMigrationResource->delete($this->getById($id));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $id)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexMigrationSearchResultsInterface
    {
        $collection = $this->cexMigrationCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

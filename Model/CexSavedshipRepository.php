<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\CexSavedshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexSavedshipRepository implements CexSavedshipRepositoryInterface
{
    /**
     * @var CexSavedshipFactory
     */
    private  $CexSavedshipFactory;

    /**
     * @var CexSavedship
     */
    private  $CexSavedshipResource;

    /**
     * @var CollectionFactory
     */
    private  $CexSavedshipCollectionFactory;

    /**
     * @var CexSavedshipSearchResultsInterfaceFactory
     */
    private  $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private  $collectionProcessor;

    public function __construct(
        CexSavedshipFactory $CexSavedshipFactory,
        CexSavedship $CexSavedshipResource,
        CollectionFactory $CexSavedshipCollectionFactory,
        CexSavedshipSearchResultsInterfaceFactory $CexSavedshipSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->CexSavedshipFactory              = $CexSavedshipFactory;
        $this->CexSavedshipResource             = $CexSavedshipResource;
        $this->CexSavedshipCollectionFactory    = $CexSavedshipCollectionFactory;
        $this->searchResultsFactory             = $CexSavedshipSearchResultsInterfaceFactory;
        $this->collectionProcessor              = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexSavedshipInterface
    {
        $CexSavedship = $this->CexSavedshipFactory->create();
        $this->CexSavedshipResource->load($CexSavedship, $id);
        if(!$CexSavedship->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexSavedship with id: "%1"', $id));
        }
        return $CexSavedship;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface $CexSavedship
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface
     */
    public function save(CexSavedshipInterface $CexSavedship): CexSavedshipInterface
    {
        $this->CexSavedshipResource->save($CexSavedship);
        return $CexSavedship;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface $CexSavedship
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexSavedshipInterface $CexSavedship): bool
    {
        try {
            $this->CexSavedshipResource->delete($CexSavedship);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $CexSavedship)
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
            $this->CexSavedshipResource->delete($this->getById($id));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $id)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexSavedshipSearchResultsInterface
    {
        $collection = $this->CexSavedshipCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

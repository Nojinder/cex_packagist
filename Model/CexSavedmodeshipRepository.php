<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\CexSavedmodeshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedmodeship\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedmodeship;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexSavedmodeshipRepository implements CexSavedmodeshipRepositoryInterface
{
    /**
     * @var CexSavedmodeshipFactory
     */
    private  $cexSavedmodeshipFactory;

    /**
     * @var CexSavedmodeship
     */
    private  $cexSavedmodeshipResource;

    /**
     * @var CollectionFactory
     */
    private  $cexSavedmodeshipCollectionFactory;

    /**
     * @var CexSavedmodeshipSearchResultsInterfaceFactory
     */
    private  $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private  $collectionProcessor;

    public function __construct(
        CexSavedmodeshipFactory $cexSavedmodeshipFactory,
        CexSavedmodeship $cexSavedmodeshipResource,
        CollectionFactory $cexSavedmodeshipCollectionFactory,
        CexSavedmodeshipSearchResultsInterfaceFactory $cexSavedmodeshipSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexSavedmodeshipFactory              = $cexSavedmodeshipFactory;
        $this->cexSavedmodeshipResource             = $cexSavedmodeshipResource;
        $this->cexSavedmodeshipCollectionFactory    = $cexSavedmodeshipCollectionFactory;
        $this->searchResultsFactory                 = $cexSavedmodeshipSearchResultsInterfaceFactory;
        $this->collectionProcessor                  = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexSavedmodeshipInterface
    {
        $cexSavedmodeship = $this->cexSavedmodeshipFactory->create();
        $this->cexSavedmodeshipResource->load($cexSavedmodeship, $id);
        if(!$cexSavedmodeship->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexSavedmodeship with id: "%1"', $id));
        }
        return $cexSavedmodeship;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface $cexSavedmodeship
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface
     */
    public function save(CexSavedmodeshipInterface $cexSavedmodeship): CexSavedmodeshipInterface
    {
        $this->cexSavedmodeshipResource->save($cexSavedmodeship);
        return $cexSavedmodeship;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipInterface $cexSavedmodeship
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexSavedmodeshipInterface $cexSavedmodeship): bool
    {
        try {
            $this->cexSavedmodeshipResource->delete($cexSavedmodeship);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $cexSavedmodeship)
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
            $this->cexSavedmodeshipResource->delete($this->getById($id));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $id)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedmodeshipSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexSavedmodeshipSearchResultsInterface
    {
        $collection = $this->cexSavedmodeshipCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

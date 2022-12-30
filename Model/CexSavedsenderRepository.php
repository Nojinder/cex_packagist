<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\CexSavedsenderRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedsender\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedsender;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexSavedsenderRepository implements CexSavedsenderRepositoryInterface
{
    /**
     * @var CexSavedsenderFactory
     */
    private  $cexSavedsenderFactory;

    /**
     * @var CexSavedsender
     */
    private  $cexSavedsenderResource;

    /**
     * @var CollectionFactory
     */
    private  $cexSavedsenderCollectionfactory;

    /**
     * @var CexSavedsenderSearchResultsInterfaceFactory
     */
    private  $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private  $collectionProcessor;

    public function __construct(
        CexSavedsenderFactory $cexSavedsenderFactory,
        CexSavedsender $cexSavedsenderResource,
        CollectionFactory $cexSavedsenderCollectionfactory,
        CexSavedsenderSearchResultsInterfaceFactory $cexSavedsenderSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexSavedsenderFactory            = $cexSavedsenderFactory;
        $this->cexSavedsenderResource           = $cexSavedsenderResource;
        $this->cexSavedsenderCollectionfactory  = $cexSavedsenderCollectionfactory;
        $this->searchResultsFactory             = $cexSavedsenderSearchResultsInterfaceFactory;
        $this->collectionProcessor              = $collectionProcessor;
    }


    /**
     * @param int $customerCodeId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $customerCodeId): cexSavedsenderInterface
    {
        $cexSavedSender = $this->cexSavedsenderFactory->create();
        $this->cexSavedsenderResource->load($cexSavedSender, $customerCodeId);
        if(!$cexSavedSender->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexSavedSender with id: "%1"', $customerCodeId));
        }
        return $cexSavedSender;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface $savedsender
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface
     */
    public function save(CexSavedsenderInterface $savedsender): CexSavedsenderInterface
    {
        $this->cexSavedsenderResource->save($savedsender);
        return $savedsender;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterface $savedsender
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexSavedsenderInterface $savedsender): bool
    {
        try {
            $this->cexSavedsenderResource->delete($savedsender);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $savedsender)
            );
        }
        return true;
    }

    /**
     * @param int $customerCodeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $customerCodeId): bool
    {
        try {
            $this->cexSavedsenderResource->delete($this->getById($customerCodeId));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $customerCodeId)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexSavedsenderSearchResultsInterface
    {
        $collection = $this->cexSavedsenderCollectionfactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}




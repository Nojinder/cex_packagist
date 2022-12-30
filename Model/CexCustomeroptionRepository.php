<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomeroption\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomeroption;
use CorreosExpress\RegistroDeEnvios\Api\CexCustomeroptionRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexCustomeroptionRepository implements CexCustomeroptionRepositoryInterface
{
    /**
     * @var CexCustomeroptionFactory
     */
    private $cexCustomeroptionFactory;

    /**
     * @var CexCustomeroption
     */
    private $cexCustomeroptionResource;

    /**
     * @var CexCustomeroptionSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionFactory
     */
    private $cexCustomeroptionCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        CexCustomeroptionFactory $cexCustomeroptionFactory,
        CexCustomeroption $cexCustomeroptionResource,
        CollectionFactory $cexCustomeroptionCollectionFactory,
        CexCustomeroptionSearchResultsInterfaceFactory $cexCustomeroptionSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexCustomeroptionFactory             = $cexCustomeroptionFactory;
        $this->cexCustomeroptionResource            = $cexCustomeroptionResource;
        $this->cexCustomeroptionCollectionFactory   = $cexCustomeroptionCollectionFactory;
        $this->searchResultsFactory                 = $cexCustomeroptionSearchResultsInterfaceFactory;
        $this->collectionProcessor                  = $collectionProcessor;
    }

    /**
     * @param int $customerOptionsId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $customerOptionsId): CexCustomeroptionInterface
    {
        $cexCustomeroption = $this->cexCustomeroptionFactory->create();
        $this->cexCustomeroptionResource->load($cexCustomeroption, $customerOptionsId);
        if(!$cexCustomeroption->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexCustomeroption with id: "%1"', $customerOptionsId));
        }
        return $cexCustomeroption;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface $cexCustomeroption
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface
     */
    public function save(CexCustomeroptionInterface $cexCustomeroption): CexCustomeroptionInterface
    {
        $this->cexCustomeroptionResource->save($cexCustomeroption);
        return $cexCustomeroption;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface $cexCustomeroption
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexCustomeroptionInterface $cexCustomeroption): bool
    {
        try {
            $this->cexCustomeroptionResource->delete($cexCustomeroption);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $cexCustomeroption)
            );
        }
        return true;
    }

    /**
     * @param int $customerOptionsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $customerOptionsId): bool
    {
        try {
            $this->cexCustomeroptionResource->delete($this->getById($customerOptionsId));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $customerOptionsId)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexCustomeroptionSearchResultsInterface
    {
        $collection = $this->cexCustomeroptionCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

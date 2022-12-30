<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Api\CexCustomercodeRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeSearchResultsInterfaceFactory;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexCustomercodeRepository implements CexCustomercodeRepositoryInterface
{

    /**
     * @var \CorreosExpress\RegistroDeEnvios\Model\CexCustomercodeFactory
     */
    private $cexCustomercodeFactory;

    /**
     * @var CexCustomercode
     */
    private $cexCustomercodeResource;

    /**
     * @var CexCustomercodeSearchResultsInterfaceFactory
     */
    private $searchResultsInterface;

    /**
     * @var CollectionFactory
     */
    private $cexCustomercodeCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param CexCustomercodeFactory $cexCustomercodeFactory
     * @param CexCustomercode $cexCustomercodeResource
     * @param CexCustomercodeSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionFactory $cexCustomercodeCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        CexCustomercodeFactory $cexCustomercodeFactory,
        CexCustomercode $cexCustomercodeResource,
        CexCustomercodeSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionFactory $cexCustomercodeCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexCustomercodeFactory = $cexCustomercodeFactory;
        $this->cexCustomercodeResource = $cexCustomercodeResource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->cexCustomercodeCollectionFactory = $cexCustomercodeCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }


    /**
     * @param int $customerCodeId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $customerCodeId): CexCustomercodeInterface
    {
        $cexCustomercode = $this->cexCustomercodeFactory->create();
        $this->cexCustomercodeResource->load($cexCustomercode, $customerCodeId);
        if(!$cexCustomercode->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexCustomercode with id: "%1"', $customerCodeId));
        }
        return $cexCustomercode;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface $customer
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface
     */
    public function save(CexCustomercodeInterface $customer): CexCustomercodeInterface
    {
        $this->cexCustomercodeResource->save($customer);
        return $customer;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterface $customer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexCustomercodeInterface $customer): bool
    {
        try {
            $this->cexCustomercodeResource->delete($customer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $customer)
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
            $this->cexCustomercodeResource->delete($this->getById($customerCodeId));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id : %1', $customerCodeId)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexCustomercodeSearchResultsInterface
    {
        $collection = $this->cexCustomercodeCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

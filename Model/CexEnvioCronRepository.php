<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\CexEnvioCronRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnvioCron;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnvioCron\CollectionFactory;

class CexEnvioCronRepository implements CexEnvioCronRepositoryInterface
{

    /**
     * @var CexEnvioCronFactory
     */
    private $cexEnvioCronFactory;

    /**
     * @var CexEnvioCron
     */
    private $cexEnvioCronResource;

    /**
     * @var CexEnvioCronCollectionFactory
     */
    private $cexEnvioCronCollectionFactory;

    /**
     * @var CexEnvioCronSearchResultsInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        CexEnvioCronFactory $cexEnvioCronFactory,
        CexEnvioCron $cexEnvioCronResource,
        CollectionFactory $cexEnvioCronCollectionFactory,
        CexEnvioCronSearchResultsInterfaceFactory $cexEnvioCronSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->cexEnvioCronFactory              = $cexEnvioCronFactory;
        $this->cexEnvioCronResource             = $cexEnvioCronResource;
        $this->cexEnvioCronCollectionFactory    = $cexEnvioCronCollectionFactory;
        $this->searchResultFactory              = $cexEnvioCronSearchResultInterfaceFactory;
        $this->collectionProcessor              = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): CexEnvioCronInterface
    {
        $cexEnvioCron = $this->cexEnvioCronFactory->create();
        $this->cexEnvioCronResource->load($cexEnvioCron, $id);
        if (!$cexEnvioCron->getId()) {
            throw new NoSuchEntityException(__('Unable to find CexEnvioCron with ID "%1"', $id));
        }
        return $cexEnvioCron;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface $cexEnvioCron
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(CexEnvioCronInterface $cexEnvioCron): \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface
    {
        $this->cexEnvioCronResource->save($cexEnvioCron);
        return $cexEnvioCron;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterface $cexEnvioCron
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexEnvioCronInterface $cexEnvioCron)
    {
        try {
            $this->cexEnvioCronResource->delete($cexEnvioCron);
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
            $this->CexEnvioCronResource->delete($this->getById($id));
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $id)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronSearchResultsInterface
    {
        $collection = $this->cexEnvioCronCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

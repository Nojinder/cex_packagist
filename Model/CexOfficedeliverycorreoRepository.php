<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\CexOfficedeliverycorreoRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexOfficedeliverycorreo\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexOfficedeliverycorreo;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class CexOfficedeliverycorreoRepository implements CexOfficedeliverycorreoRepositoryInterface
{
    /**
     * @var CexOfficedeliverycorreoFactory
     */
    private $cexOfficedeliverycorreoFactory;

    /**
     * @var CexOfficedeliverycorreo
     */
    private $cexOfficedeliverycorreoResource;

    /**
     * @var CollectionFactory
     */
    private $cexOfficedeliverycorreoCollectionfactory;

    /**
     * @var CexOfficedeliverycorreoSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        CexOfficedeliverycorreoFactory $cexOfficedeliverycorreoFactory,
        CexOfficedeliverycorreo $cexOfficedeliverycorreoResource,
        CollectionFactory $cexOfficedeliverycorreoCollectionfactory,
        CexOfficedeliverycorreoSearchResultsInterfaceFactory $cexOfficedeliverycorreoSearchResultsFactory,
        CollectionProcessorInterface $collectionProcessor

    ){
        $this->cexOfficedeliverycorreoFactory           = $cexOfficedeliverycorreoFactory;
        $this->cexOfficedeliverycorreoResource          = $cexOfficedeliverycorreoResource;
        $this->cexOfficedeliverycorreoCollectionfactory = $cexOfficedeliverycorreoCollectionfactory;
        $this->searchResultsFactory                     = $cexOfficedeliverycorreoSearchResultsFactory;
        $this->collectionProcessor                      = $collectionProcessor;
    }


    /**
     * @param int $officeDeliveryCorreoId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $officeDeliveryCorreoId): CexOfficedeliverycorreoInterface
    {
        $cexOfficedeliverycorreo = $this->cexOfficedeliverycorreoFactory->create();
        $this->cexOfficedeliverycorreoResource->load($cexOfficedeliverycorreo, $officeDeliveryCorreoId);
        if(!$cexOfficedeliverycorreo->getId())
        {
            throw new NoSuchEntityException(__('Unable to find CexOfficeDeliverycorreo with id: "%1"', $officeDeliveryCorreoId));
        }
        return $cexOfficedeliverycorreo;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface $cexOfficedeliverycorreo
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface
     */
    public function save(CexOfficedeliverycorreoInterface $cexOfficedeliverycorreo): CexOfficedeliverycorreoInterface
    {
       $this->cexOfficedeliverycorreoResource->save($cexOfficedeliverycorreo);
       return $cexOfficedeliverycorreo;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterface $cexOfficeDeliveryCorreo
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexOfficedeliverycorreoInterface $cexOfficeDeliveryCorreo): bool
    {
        try{
            $this->cexOfficedeliverycorreoResource->delete($cexOfficeDeliveryCorreo);
        } catch(\Exception $exception){
            throw new CouldNotDeleteException(
                __('Could not delete entry: "%1"', $cexOfficeDeliveryCorreo)
            );
        }
        return true;
    }

    /**
     * @param int $officeDeliveryCorreoId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $officeDeliveryCorreoId): bool
    {
        try{
            $this->cexOfficedeliverycorreoResource->delete($this->getById($officeDeliveryCorreoId));
        } catch(\Exception $exception){
            throw new CouldNotDeleteException(
                __('Could not delete entry with id: "%1"', $officeDeliveryCorreoId)
            );
        }
        return true;
    }
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexOfficedeliverycorreoSearchResultsInterface
    {
        $collection = $this->cexOfficedeliverycorreoCollectionfactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}

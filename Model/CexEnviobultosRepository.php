<?php

namespace CorreosExpress\RegistroDeEnvios\Model;

use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosSearchResultsInterface;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnviobultos;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexEnviobultos\CollectionFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosSearchResultsInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\CexEnviobultosRepositoryInterface;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

Class CexEnviobultosRepository implements CexEnviobultosRepositoryInterface
{
    /**
     * @var CexEnviobultosFactory
     */
    private $cexEnviobultosFactory;

    /**
     * @var CexEnviobultos
     */
    private $cexEnviobultosResource;

    /**
     * @var CollectionFactory
     */
    private $cexEnviobultosCollectionFactory;

    /**
     * @var CexEnviobultosSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param CexEnviobultosFactory $cexEnviobultosFactory
     * @param CexEnviobultos $cexEnviobultosResource
     * @param CollectionFactory $cexEnviobultosCollectionFactory
     * @param CexEnviobultosSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        CexEnviobultosFactory $cexEnviobultosFactory,
        CexEnviobultos $cexEnviobultosResource,
        CollectionFactory $cexEnviobultosCollectionFactory,
        CexEnviobultosSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->cexEnviobultosFactory = $cexEnviobultosFactory;
        $this->cexEnviobultosResource = $cexEnviobultosResource;
        $this->cexEnviobultosCollectionFactory = $cexEnviobultosCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }


    /**
     * @param int $envioBultosId
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $envioBultosId): CexEnviobultosInterface
    {
        $cexEnviobultos = $this->cexEnviobultosFactory->create();
        $this->cexEnviobultosResource->load($cexEnviobultos, $envioBultosId);
        if(!$cexEnviobultos->getId()){
            throw new NoSuchEntityException(__('Unable to Find CexEnviobultos with id: "%1"', $envioBultosId));
        }
        return $cexEnviobultos;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface $envioBultos
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface
     */
    public function save(CexEnviobultosInterface $envioBultos): CexEnviobultosInterface
    {
        $this->cexEnviobultosResource->save($envioBultos);
        return $envioBultos;
    }

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterface $envioBultos
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(CexEnviobultosInterface $envioBultos): bool
    {
        try{
            $this->cexEnviobultosResource->delete($envioBultos);
        }catch (\Exception $exception){
            throw new CouldNotDeleteException(
            __('Could not delete the entry: %1', $envioBultos)
            );
        }
        return true;
    }

    public function deleteById(int $envioBultosId): bool
    {
        try{
            $this->cexEnviobultosResource->delete($this->getById($envioBultosId));
        }catch (\Exception $exception){
            throw new CouldNotDeleteException(
                __('Could not delete the entry with id: %1', $envioBultosId)
            );
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CexEnviobultosSearchResultsInterface
    {
        $collection = $this->cexEnviobultosCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

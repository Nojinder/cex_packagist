<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface CexCustomeroptionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface[]
     */
    public function getItems();

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomeroptionInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

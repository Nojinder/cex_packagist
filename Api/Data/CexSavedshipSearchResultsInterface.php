<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface CexSavedshipSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface[]
     */
    public function getItems();

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

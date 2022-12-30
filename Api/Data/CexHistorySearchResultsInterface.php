<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface CexHistorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface[]
     */
    public function getItems();

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

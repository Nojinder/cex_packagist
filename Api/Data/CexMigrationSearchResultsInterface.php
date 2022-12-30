<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
/**
 * @api
 */
interface CexMigrationSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface[]
     */
    public function getItems();

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

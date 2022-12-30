<?php

namespace CorreosExpress\RegistroDeEnvios\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
/**
 * @api
 */
interface CexRespuestaCronSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface[]
     */
    public function getItems();

    /**
     * @param \CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}

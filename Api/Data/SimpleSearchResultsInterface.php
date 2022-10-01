<?php
namespace GFNL\SimpleApi\Api\Data;

interface SimpleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \GFNL\SimpleApi\Api\Data\SimpleInterface[]
     */
    public function getItems();

    /**
     * @param \GFNL\SimpleApi\Api\Data\SimpleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

<?php

namespace ElTrubetskaia\AskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for ask a question search results.
 * @api
 */
interface AskQuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface[]
     */
    public function getItems();

    /**
     * Set question list.
     *
     * @param \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

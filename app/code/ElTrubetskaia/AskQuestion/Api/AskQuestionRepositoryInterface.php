<?php

namespace ElTrubetskaia\AskQuestion\Api;

use ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface;
use ElTrubetskaia\AskQuestion\Api\Data\AskQuestionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Ask a Question CRUD interface.
 * @api
 */
interface AskQuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface $askQuestion
     * @return \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface
     * @throws LocalizedException
     */
    public function save(AskQuestionInterface $askQuestion);

    /**
     * Retrieve question.
     *
     * @param int $askQuestionId
     * @return \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface
     * @throws LocalizedException
     */
    public function getById($askQuestionId);

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionSearchResultsInterface
     *
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     *
     * @param \ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion);

    /**
     * Delete question by ID.
     *
     * @param int $askQuestionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($askQuestionId);
}

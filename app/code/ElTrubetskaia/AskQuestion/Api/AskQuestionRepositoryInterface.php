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
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function save(AskQuestionInterface $askQuestion): AskQuestionInterface;

    /**
     * Retrieve question.
     *
     * @param int $askQuestionId
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function getById($askQuestionId): AskQuestionInterface;

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AskQuestionSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AskQuestionSearchResultsInterface;

    /**
     * Delete question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion): bool;

    /**
     * Delete question by ID.
     *
     * @param int $askQuestionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($askQuestionId): bool;
}

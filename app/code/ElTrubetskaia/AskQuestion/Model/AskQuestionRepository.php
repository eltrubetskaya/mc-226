<?php

namespace ElTrubetskaia\AskQuestion\Model;

use ElTrubetskaia\AskQuestion\Api\AskQuestionRepositoryInterface;
use ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterface;
use ElTrubetskaia\AskQuestion\Api\Data\AskQuestionSearchResultsInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use ElTrubetskaia\AskQuestion\Api\Data\AskQuestionInterfaceFactory;
use ElTrubetskaia\AskQuestion\Api\Data\AskQuestionSearchResultsInterfaceFactory;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion as ResourceAskQuestion;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory as AskQuestionCollectionFactory;

/**
 * Class AskQuestionRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AskQuestionRepository implements AskQuestionRepositoryInterface
{
    /**
     * @var ResourceAskQuestion
     */
    protected $resource;

    /**
     * @var AskQuestionFactory
     */
    protected $askQuestionFactory;

    /**
     * @var AskQuestionCollectionFactory
     */
    protected $askQuestionCollectionFactory;

    /**
     * @var AskQuestionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var AskQuestionInterfaceFactory
     */
    protected $dataAskQuestionFactory;

    public function __construct(
        ResourceAskQuestion $resource,
        AskQuestionFactory $askQuestionFactory,
        AskQuestionInterfaceFactory $dataAskQuestionFactory,
        AskQuestionCollectionFactory $askQuestionCollectionFactory,
        AskQuestionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->askQuestionFactory = $askQuestionFactory;
        $this->askQuestionCollectionFactory = $askQuestionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAskQuestionFactory = $dataAskQuestionFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save AskQuestion data
     *
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(AskQuestionInterface $askQuestion): AskQuestionInterface
    {
        try {
            $this->resource->save($askQuestion);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $askQuestion;
    }

    /**
     * Retrieve question.
     *
     * @param int $askQuestionId
     * @return AskQuestionInterface
     * @throws LocalizedException
     */
    public function getById($askQuestionId): AskQuestionInterface
    {
        $askQuestion = $this->askQuestionFactory->create();
        $askQuestion->load($askQuestionId);
        if (!$askQuestion->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $askQuestionId));
        }

        return $askQuestion;
    }

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return AskQuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AskQuestionSearchResultsInterface
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $collection = $this->askQuestionCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $askQuestions = [];
        /** @var AskQuestion $askQuestionModel */
        foreach ($collection as $askQuestionModel) {
            $askQuestionData = $this->dataAskQuestionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $askQuestionData,
                $askQuestionModel->getData(),
                AskQuestionInterface::class
            );
            $askQuestions[] = $this->dataObjectProcessor->buildOutputDataArray(
                $askQuestionData,
                AskQuestionInterface::class
            );
        }
        $searchResults->setItems($askQuestions);

        return $searchResults;
    }

    /**
     * Delete question.
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(AskQuestionInterface $askQuestion): bool
    {
        try {
            $this->resource->delete($askQuestion);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the question: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * Delete question by ID.
     *
     * @param int $askQuestionId
     * @return bool true on success
     * @throws LocalizedException
     */
    public function deleteById($askQuestionId): bool
    {
        return $this->delete($this->getById($askQuestionId));
    }
}

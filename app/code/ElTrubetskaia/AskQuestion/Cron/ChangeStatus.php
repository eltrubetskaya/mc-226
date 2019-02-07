<?php

namespace ElTrubetskaia\AskQuestion\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use ElTrubetskaia\AskQuestion\Model\AskQuestion;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;

class ChangeStatus
{
    private const XML_PATH_ASK_QUESTION_GET_NUMBER_OF_DAYS = 'catalog/ask_question_cron_job/ask_question_cron_job_days';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(CollectionFactory $collectionFactory, ScopeConfigInterface $scopeConfig)
    {
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(): void
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create()->load();
        /** @var AskQuestion $item */
        foreach ($collection as $item) {
            if ($item->getStatus() === AskQuestion::STATUS_PENDING) {
                $item->setStatus(AskQuestion::STATUS_PROCESSED)->save();
            }
        }
    }

    /**
     * @return integer
     */
    public function getNumberOfDays(): int
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ASK_QUESTION_GET_NUMBER_OF_DAYS,
            ScopeInterface::SCOPE_STORE
        );
    }
}

<?php

namespace ElTrubetskaia\AskQuestion\Cron;

use ElTrubetskaia\AskQuestion\Model\Config\Source\ListMode;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use ElTrubetskaia\AskQuestion\Model\AskQuestion;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;

class ChangeStatus
{
    /**
     * Configuration path to customer Ask a Question cron schedule
     */
    private const XML_PATH_ASK_QUESTION_CRON_SCHEDULE = 'catalog/ask_question_cron_job/ask_question_cron_schedule';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ListMode
     */
    private $listMode;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param ListMode $listMode
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig,
        ListMode $listMode
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->listMode = $listMode;
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
     * @return int
     */
    public function getNumberOfDays(): int
    {
        foreach ($this->listMode->toOptionArray() as $key => $item) {
            if ($item ['value'] === $this->getCronSchedule()) {
                return $item ['days'];
            }
        }

        return 0;
    }

    /**
     * @return string
     */
    public function getCronSchedule(): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ASK_QUESTION_CRON_SCHEDULE,
            ScopeInterface::SCOPE_STORE
        );
    }
}

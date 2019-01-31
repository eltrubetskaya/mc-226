<?php

namespace ElTrubetskaia\AskQuestion\Cron;

use ElTrubetskaia\AskQuestion\Model\AskQuestion;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;

class ChangeStatus
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create()->load();
        /** @var AskQuestion $item */
        foreach ($collection as $item) {

        }
    }
}

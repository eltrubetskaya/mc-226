<?php

namespace ElTrubetskaia\AskQuestion\Block;

use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\Collection;
use ElTrubetskaia\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Question extends Template
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Registry $registry
     */
    private $registry;

    /**
     * Requests constructor.
     * @param CollectionFactory $collectionFactory
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->registry = $registry;
    }

    /**
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getAskQuestionsForProduct(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->addFieldToFilter('sku', $this->getCurrentProduct()->getSku())
            ->getSelect()
            ->orderRand();
        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }

        return $collection;
    }

    /**
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }
}

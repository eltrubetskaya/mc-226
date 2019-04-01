<?php

namespace ElTrubetskaia\Lesson14\Model;

use Magento\Catalog\Model\ProductRepository;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\DB\Transaction;
use Magento\Framework\DB\TransactionFactory;

class ProductManagement
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var StockRegistryInterface
     */
    private $stockRegistry;

    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * @param ProductRepository $productRepository
     * @param StockRegistryInterface $stockRegistry
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(
        ProductRepository $productRepository,
        TransactionFactory $transactionFactory,
        StockRegistryInterface $stockRegistry
    ) {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param $productId
     * @param $quantity
     *
     * @return boolean
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Exception
     */
    public function setQuantity($productId, $quantity): bool
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();

        $product = $this->productRepository->getById($productId);

        if (!is_numeric($quantity)) {
            throw new \InvalidArgumentException(__('Type of quantity must be float or integer'));
        }

        $stockItem = $this->stockRegistry->getStockItemBySku($product->getSku());
        $stockItem->setQty($quantity);
        $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);

        $transaction->save();

        return true;
    }
}

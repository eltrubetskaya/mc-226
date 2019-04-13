<?php
namespace ElTrubetskaia\Lesson18\Controller\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Context;

class GetList extends \Magento\Framework\App\Action\Action
{
    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($q = $this->getRequest()->getParam('q')) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder
                    ->setField('name')
                    ->setValue('%'.$q.'%')
                    ->setConditionType('like')
                    ->create()
            );
        }
        $this->searchCriteriaBuilder->addSortOrder('name', 'ASC');
        $this->searchCriteriaBuilder->setPageSize(10);
        $this->searchCriteriaBuilder->setCurrentPage(1);

        $products = $this->productRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'price' => $product->getPrice()
            ];
        }

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);

        return $result->setData([
            'products' => $data,
            'error' => false
        ]);
    }
}

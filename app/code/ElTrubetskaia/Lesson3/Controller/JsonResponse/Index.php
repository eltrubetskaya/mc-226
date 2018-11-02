<?php

namespace ElTrubetskaia\Lesson3\Controller\JsonResponse;


use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $controllerResult */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = ['Default Router Is' => 'https://inchoo.net/magento-2/routing-in-magento-2/'];

        return $controllerResult->setData($data);
    }
}

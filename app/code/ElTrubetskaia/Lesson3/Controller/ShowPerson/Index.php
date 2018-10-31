<?php

namespace ElTrubetskaia\Lesson3\Controller\ShowPerson;


use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{

    const NAME = 'Elena';

    const LAST_NAME = 'Trubetskaia';

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getLayout()
            ->getBlock('home_work')
            ->setName(self::NAME);
        $resultPage->getLayout()
            ->getBlock('home_work')
            ->setLastName(self::LAST_NAME);

        return $resultPage;
    }
}

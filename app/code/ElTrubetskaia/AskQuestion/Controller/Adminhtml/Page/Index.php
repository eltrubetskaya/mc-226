<?php

namespace ElTrubetskaia\AskQuestion\Controller\Adminhtml\Page;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'ElTrubetskaia_AskQuestion::page';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ElTrubetskaia_AskQuestion::ask_question');
        $resultPage->addBreadcrumb(__('AskQuestion'), __('AskQuestion'));
        $resultPage->addBreadcrumb(__('Manage'), __('Manage'));
        $resultPage->getConfig()->getTitle()->prepend(__('AskQuestion content'));

        $dataPersistor = $this->_objectManager->get(\Magento\Framework\App\Request\DataPersistorInterface::class);
        $dataPersistor->clear('ask_question');

        return $resultPage;
    }
}

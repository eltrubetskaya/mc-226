<?php

namespace ElTrubetskaia\Lesson3\Controller\ShowPerson;


class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
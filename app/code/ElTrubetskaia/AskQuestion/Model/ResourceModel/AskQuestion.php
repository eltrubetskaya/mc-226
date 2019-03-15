<?php

namespace ElTrubetskaia\AskQuestion\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AskQuestion extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('el_ask_question', 'question_id');
    }
}

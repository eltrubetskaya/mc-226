<?php

namespace ElTrubetskaia\AskQuestion\Model\Config\Source;

use ElTrubetskaia\AskQuestion\Model\AskQuestion;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Pending'),
                'value' => AskQuestion::STATUS_PENDING,
            ],
            [
                'label' => __('Processed'),
                'value' => AskQuestion::STATUS_PROCESSED,
            ],
        ];
    }
}

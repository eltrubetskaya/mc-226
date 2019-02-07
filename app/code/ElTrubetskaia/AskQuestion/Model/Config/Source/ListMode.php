<?php

namespace ElTrubetskaia\AskQuestion\Model\Config\Source;

class ListMode implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('Once a Day')],
            ['value' => '3', 'label' => __('Every 3 Days')],
            ['value' => '7', 'label' => __('Once a Week')],
        ];
    }
}

<?php

namespace ElTrubetskaia\Lesson3\Block;

use Magento\Framework\View\Element\Template;

class CustomBlock extends Template
{
    /**
     * @return string
     */
    public function generateUrl(): string
    {
        return $this->getUrl('el_lesson3/jsonresponse/index');
    }
}

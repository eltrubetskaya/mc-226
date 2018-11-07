<?php

namespace ElTrubetskaia\Lesson3\Block;

use Magento\Framework\View\Element\Template;

class CustomBlock extends Template
{
    public function generateUrl()
    {
        return $this->getUrl('el_lesson3/jsonresponse/index');
    }
}

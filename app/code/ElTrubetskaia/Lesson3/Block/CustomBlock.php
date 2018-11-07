<?php

namespace ElTrubetskaia\Lesson3\Block;

use Magento\Framework\View\Element\Template;

class CustomBlock extends Template
{
    public function generateUrl()
    {
        return $this->getUrl('home_work/jsonresponse/index');
    }
}

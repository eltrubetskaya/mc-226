<?php

namespace ElTrubetskaia\CustomWidget\Setup;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Construct
     *
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $page = $this->pageFactory->create();
            $page->setTitle('Geekhub CMS page')
                ->setIdentifier('geekhub-cms')
                ->setIsActive(true)
                ->setPageLayout('1column')
                ->setStores([0])
                ->setContent('CustomWidget Page')
                ->save();
        }

        $setup->endSetup();
    }
}

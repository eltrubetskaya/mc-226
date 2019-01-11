<?php

namespace ElTrubetskaia\AskQuestion\Setup;

use ElTrubetskaia\AskQuestion\Model\AskQuestion;
use ElTrubetskaia\AskQuestion\Model\AskQuestionFactory;
use Magento\Framework\DB\Transaction;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Store\Model\Store;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * @var ComponentRegistrar $componentRegistrar
     */
    private $componentRegistrar;

    /**
     * @var TransactionFactory
     */
    private $transactionFactory;

    /**
     * UpgradeData constructor.
     * @param AskQuestionFactory $askQuestionFactory
     * @param ComponentRegistrar $componentRegistrar
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(
        AskQuestionFactory $askQuestionFactory,
        ComponentRegistrar $componentRegistrar,
        TransactionFactory $transactionFactory
    ) {
        $this->askQuestionFactory = $askQuestionFactory;
        $this->componentRegistrar = $componentRegistrar;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $statuses = [AskQuestion::STATUS_PENDING, AskQuestion::STATUS_PROCESSED];
            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();
            for ($i = 1; $i <= 5; $i++) {
                /** @var AskQuestion $askQuestion */
                $askQuestion = $this->askQuestionFactory->create();
                $askQuestion
                    ->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setSku("24-MB0$i")
                    ->setQuestion('Just a test question')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($askQuestion);
            }
            $transaction->save();
        }

        $setup->endSetup();
    }
}

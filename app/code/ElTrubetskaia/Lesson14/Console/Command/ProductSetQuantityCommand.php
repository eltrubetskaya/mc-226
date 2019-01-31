<?php

namespace ElTrubetskaia\Lesson14\Console\Command;

use ElTrubetskaia\Lesson14\Model\ProductManagement;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductSetQuantityCommand extends Command
{
    private const ARG_PRODUCT_ID = 'productId';
    private const ARG_PRODUCT_QUANTITY = 'quantity';

    /**
     * @var State
     */
    private $state;

    /**
     * @var ProductManagement
     */
    private $productManagement;

    /**
     * @param State $state
     * @param ProductManagement $productManagement
     * @param string|null $name
     */
    public function __construct(
        State $state,
        ProductManagement $productManagement,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->state = $state;
        $this->productManagement = $productManagement;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:product:set:quantity')
            ->setDescription('Set Quantity in Product')
            ->setDefinition([
                new InputArgument(
                    static::ARG_PRODUCT_ID,
                    InputArgument::REQUIRED,
                    'Product Id'
                ),
                new InputArgument(
                    static::ARG_PRODUCT_QUANTITY,
                    InputArgument::REQUIRED,
                    'Set product quantity'
                )
            ]);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->emulateAreaCode(
                Area::AREA_ADMINHTML,
                [$this->productManagement, 'setQuantity'],
                [$input->getArgument('productId'), $input->getArgument('quantity')]
            );
            $output->writeln('<info>Completed!<info>');
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}<error>");
        }
    }
}

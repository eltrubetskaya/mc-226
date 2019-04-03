<?php

namespace ElTrubetskaia\AskQuestion\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use ElTrubetskaia\AskQuestion\Model\AskQuestion;

/**
 * Upgrade the AskQuestion module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            /**
             * Create table 'el_ask_question'
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable('el_ask_question')
            )->addColumn(
                'question_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Question ID'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Name'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Email'
            )->addColumn(
                'phone',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                63,
                ['nullable' => false],
                'Phone'
            )->addColumn(
                'sku',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                63,
                ['nullable' => false],
                'Sku'
            )->addColumn(
                'question',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                512,
                ['nullable' => false],
                'Question'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updating Time'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                15,
                ['nullable' => false, 'default' => AskQuestion::STATUS_PENDING],
                'Status'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Store ID'
            )->addForeignKey(
                $installer->getFkName(
                    $installer->getTable('el_ask_question'),
                    'store_id',
                    'store',
                    'store_id'
                ),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Ask Question'
            );

            $installer->getConnection()->createTable($table);
        }

        if (version_compare($context->getVersion(), '0.0.6', '<')) {
            /**
             * Add column 'Customer id to 'el_ask_question'
             */
            $tableName = $setup->getTable('el_ask_question');
            if ($setup->getConnection()->isTableExists($tableName) === true) {
                $connection = $setup->getConnection();
                $connection->addColumn(
                    $tableName,
                    'customer_id',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'size' => 10,
                        'unsigned' => true,
                        'nullable' => false,
                        'comment' => 'Customer ID',
                    ]
                );
                $setup->getConnection()->addForeignKey(
                    $installer->getFkName(
                        $installer->getTable('el_ask_question'),
                        'customer_id',
                        'customer_entity',
                        'entity_id'
                    ),
                    $tableName,
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                );
            }
        }

        $installer->endSetup();
    }
}

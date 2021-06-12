<?php
/**
 * @author:  MonishTrivedi
 * @package: TrainingMonish_LoginIP
 */


namespace TrainingMonish\LoginIP\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package TrainingMonish\LoginIP\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('trainingmonish_loginip_login_log')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('trainingmonish_loginip_login_log'))
                ->addColumn('id', Table::TYPE_INTEGER, null, [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'  => true
                ], 'Login Log')
                ->addColumn('time', Table::TYPE_TIMESTAMP, null, [], 'Time')
                ->addColumn('user_name', Table::TYPE_TEXT, '64k', [], 'User Name')
                ->addColumn('ip', Table::TYPE_TEXT, '64k', [], 'IP address')
                ->addColumn('browser_agent', Table::TYPE_TEXT, '64k', [], 'Browser Agent')
                ->addColumn('url', Table::TYPE_TEXT, '64k', [], 'URL')
                ->addColumn('referer', Table::TYPE_TEXT, '64k', [], 'Referer')
                ->addColumn('status', Table::TYPE_BOOLEAN, null, [], 'Status')
                ->addColumn('is_sent_mail', Table::TYPE_BOOLEAN, null, [], 'Is sent mail')
                ->addColumn('is_warning', Table::TYPE_BOOLEAN, null, [], 'Is Warning')
                ->setComment('Mageplaza Security Login Log Table');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}

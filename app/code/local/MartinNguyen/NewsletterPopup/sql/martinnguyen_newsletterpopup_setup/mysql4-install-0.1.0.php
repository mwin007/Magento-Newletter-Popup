<?php
/**
 * NewsletterPopup database setup
 *
 * @category   MartinNguyen
 * @package    MartinNguyen_NewsletterPopup
 * @author     Martin Nguyen
 */

$installer = $this;
$installer->startSetup();

// add additional columns to "newsletter_subscriber" table
$tableName = $installer->getTable('newsletter_subscriber');
$installer->getConnection()->addColumn($tableName, 'subscriber_postal', array(
    'nullable' => true,
    'length' => 255,
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment' => 'added from extension ExtendedNewsletterSubscription'
));
$installer->getConnection()->addColumn($tableName, 'subscriber_mobile', array(
    'nullable' => true,
    'length' => 255,
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment' => 'added from extension ExtendedNewsletterSubscription'
));
$installer->getConnection()->addColumn($tableName, 'subscriber_country', array(
    'nullable' => true,
    'length' => 255,
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment' => 'added from extension ExtendedNewsletterSubscription'
));
$installer->getConnection()->addColumn($tableName, 'subscriber_dob', array(
    'nullable' => true,
    'type' => Varien_Db_Ddl_Table::TYPE_DATETIME,
    'comment' => 'added from extension ExtendedNewsletterSubscription'
));

$installer->endSetup();
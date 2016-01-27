<?php
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$installer->getTable('sugarcrm/fields_map')}
	CHANGE `fields_mapping_type` `fields_mapping_type` ENUM('".Belitsoft_Sugarcrm_Model_Connection::SYNC_MAGEFIELD."', '".Belitsoft_Sugarcrm_Model_Connection::SYNC_CUSTOM."', '".Belitsoft_Sugarcrm_Model_Connection::SYNC_EVALCODE."');
");


$installer->getConnection()->addColumn($installer->getTable('sugarcrm/fields_map'),
	'custom_model', 
	'varchar(255) NOT NULL AFTER `mage_customer_field`'
);

$installer->endSetup();
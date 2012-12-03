<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute('customer', 'stripe_customer_id', array(
		'label'		=> 'Stripe ID',
		'type'		=> 'varchar',
		'input'		=> 'text',
		'visible'	=> true,
		'required'	=> false,
		'position'	=> 1,
));

$installer->run("
 
ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `stripe_token` VARCHAR( 255 ) NOT NULL;
ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `create_stripe_customer` TINYINT( 4 ) NOT NULL DEFAULT 0;
ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `stripe_customer_id` VARCHAR( 255 ) NOT NULL ;
 
ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `stripe_token` VARCHAR( 255 ) NOT NULL;
ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `create_stripe_customer` TINYINT( 4 ) NOT NULL DEFAULT 0;
ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `stripe_customer_id` VARCHAR( 255 ) NOT NULL ;
 
");

$installer->endSetup();
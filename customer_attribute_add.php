<?php
include('app/Mage.php');
Mage::app();

$installer = Mage::getResourceModel('customer/setup', 'customer_setup');
$installer->startSetup();

$installer->addAttribute('customer','location_state', array(
    'label'             => 'Source State',
    'type'              => 'text',    //backend_type
    'input'             => 'text', //frontend_input
    'global'            =>  Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => false,
    'default'           => '',
    'frontend'          => '',
    'unique'            => false,
    'note'              => ''
));

Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'location_state')
    ->setData('used_in_forms', array(
        'customer_account_create', 'customer_account_edit', 'customer_address_edit',
        'checkout_onepage_register', 'checkout_onepage_register_guest', 'checkout_onepage_billing_address',
        'adminhtml_customer','checkout_onepage_shipping_address','checkout_multishipping_register'
    ))
    ->save();
$installer->endSetup();
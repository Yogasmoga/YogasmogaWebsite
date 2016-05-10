<?php
include('app/Mage.php');
Mage::app();

$order_details = Mage::getModel('sales/order')->loadByIncrementId(100012330);
echo "<pre/>";
print_r($order_details->getAllVisibleItems());
foreach($order_details as $points){


}



/*
Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));


    $installer = new Mage_Sales_Model_Mysql4_Setup;

    // change details below:
    $attribute  = array(
        'type' => 'varchar',
        'label'=> 'YS Color Tech',
        'input' => 'text',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => "",
        'group' => "General Information"
    );

    $installer->addAttribute('catalog_category', 'ys_color_tech', $attribute);

    $installer->endSetup();
*/

/*
$installer = Mage::getResourceModel('customer/setup', 'customer_setup');
$installer->startSetup();

$installer->addAttribute('customer','location_zip', array(
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
    ->getAttribute('customer', 'location_zip')
    ->setData('used_in_forms', array(
        'customer_account_create', 'customer_account_edit', 'customer_address_edit',
        'checkout_onepage_register', 'checkout_onepage_register_guest', 'checkout_onepage_billing_address',
        'adminhtml_customer','checkout_onepage_shipping_address','checkout_multishipping_register'
    ))
    ->save();
$installer->endSetup();*/
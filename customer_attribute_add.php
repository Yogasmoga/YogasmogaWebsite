<?php

include('app/Mage.php');
Mage::app();
/*
$setup = Mage::getModel('customer/entity_setup');
$setup->addAttribute('customer', 'city', array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'City',
    'global' => 1,
    'visible' => 1,
    'required' => 0,
    'user_defined' => 1,
    'default' => '0',
    'visible_on_front' => 1
));

$customer = Mage::getModel('customer/customer');
$attrSetId = $customer->getResource()->getEntityType()->getDefaultAttributeSetId();
$setup->addAttributeToSet('customer', $attrSetId, 'General', 'City');
*/

// This installer scripts adds a product attribute to Magento programmatically.
/*
// Set data:
$attributeName  = 'City'; // Name of the attribute
$attributeCode  = 'city'; // Code of the attribute
$attributeGroup = 'General';          // Group to add the attribute to
$attributeSetIds = array(4);          // Array with attribute set ID's to add this attribute to. (ID:4 is the Default Attribute Set)

// Configuration:
$data = array(
    'type'      => 'varchar',       // Attribute type
    'input'     => 'text',          // Input type
    'global'    => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,    // Attribute scope
    'required'  => false,           // Is this attribute required?
    'user_defined' => false,
    'searchable' => true,
    'filterable' => true,
    'comparable' => false,
    'visible_on_front' => true,
    'unique' => false,
    // Filled from above:
    'label' => $attributeName
);

// Create attribute:
// We create a new installer class here so we can also use this snippet in a non-EAV setup script.
$installer = Mage::getResourceModel('customer/setup', 'customer_setup');
$installer->startSetup();

$entity = $installer->getEntityTypeId('customer');
if(!$installer->attributeExists($entity, 'city')) {
    $installer->removeAttribute($entity, 'city');
}

$installer->addAttribute('customer_entity', $attributeCode, $data);

// Add the attribute to the proper sets/groups:
foreach($attributeSetIds as $attributeSetId)
{
    $installer->addAttributeToGroup('customer_entity', $attributeSetId, $attributeGroup, $attributeCode);
}

// Done:
$installer->endSetup();
*/

$installer = Mage::getResourceModel('customer/setup', 'customer_setup');
$installer->startSetup();

$installer->addAttribute('customer','location_city', array(
    'label'             => 'Source City',
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
    ->getAttribute('customer', 'location_city')
    ->setData('used_in_forms', array(
        'customer_account_create', 'customer_account_edit', 'customer_address_edit',
        'checkout_onepage_register', 'checkout_onepage_register_guest', 'checkout_onepage_billing_address',
        'adminhtml_customer','checkout_onepage_shipping_address','checkout_multishipping_register'
    ))
    ->save();
$installer->endSetup();
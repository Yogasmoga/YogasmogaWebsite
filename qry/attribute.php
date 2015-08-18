<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$entityTypeCode = 'catalog_category';

//$attributeCode    = 'mobile_description';
//$installer->removeAttribute($entityTypeCode , $attributeCode); die ;//remove the attribute.

$entityTypeId     = $installer->getEntityTypeId($entityTypeCode);
$attributeSetId   = $installer->getDefaultAttributeSetId($entityTypeId);
//$attributeGroupId = $installer->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);
$attributeGroupId = 4;


$installer->addAttribute('catalog_category', 'mobile_description',  array(
    'type'     => 'text', 
    'label'    => 'Mobile Description', 
    'input'    => 'textarea', 
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'           => TRUE,
    'required'          => FALSE,
    'user_defined'      => FALSE,
	'default'           => ''
));

$installer->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    'mobile_description',
    '4' );
$installer->endSetup();

?>

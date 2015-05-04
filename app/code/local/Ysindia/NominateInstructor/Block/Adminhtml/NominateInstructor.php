<?php
class Ysindia_NominateInstructor_Block_Adminhtml_NominateInstructor extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_nominateinstructor';
    $this->_blockGroup = 'nominateinstructor';
    $this->_headerText = Mage::helper('nominateinstructor')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('nominateinstructor')->__('Add Item');
    parent::__construct();
  }
}
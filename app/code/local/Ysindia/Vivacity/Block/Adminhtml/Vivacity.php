<?php
class Ysindia_Vivacity_Block_Adminhtml_Vivacity extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_vivacity';
    $this->_blockGroup = 'vivacity';
    $this->_headerText = Mage::helper('vivacity')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('vivacity')->__('Add Item');
    parent::__construct();
  }
}
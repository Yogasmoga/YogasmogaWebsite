<?php
class Ysindia_Bannerslider_Block_Adminhtml_Bannerslider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_bannerslider';
    $this->_blockGroup = 'bannerslider';
    $this->_headerText = Mage::helper('bannerslider')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('bannerslider')->__('Add Item');
    parent::__construct();
  }
}
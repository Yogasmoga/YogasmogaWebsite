<?php
class Ysindia_Sharesmogi_Block_Adminhtml_Sharesmogi extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_sharesmogi';
    $this->_blockGroup = 'sharesmogi';
    $this->_headerText = Mage::helper('sharesmogi')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('sharesmogi')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
  }
}
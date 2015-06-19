<?php

class Ysindia_Vivacity_Block_Adminhtml_Vivacity_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('vivacity_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('vivacity')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('vivacity')->__('Item Information'),
          'title'     => Mage::helper('vivacity')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('vivacity/adminhtml_vivacity_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
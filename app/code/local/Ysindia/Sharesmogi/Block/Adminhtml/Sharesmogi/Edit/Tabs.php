<?php

class Ysindia_Sharesmogi_Block_Adminhtml_Sharesmogi_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('sharesmogi_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sharesmogi')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sharesmogi')->__('Item Information'),
          'title'     => Mage::helper('sharesmogi')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('sharesmogi/adminhtml_sharesmogi_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
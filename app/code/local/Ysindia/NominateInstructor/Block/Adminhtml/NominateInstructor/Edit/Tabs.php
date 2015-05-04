<?php

class Ysindia_NominateInstructor_Block_Adminhtml_NominateInstructor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('nominateinstructor_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('nominateinstructor')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('nominateinstructor')->__('Item Information'),
          'title'     => Mage::helper('nominateinstructor')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('nominateinstructor/adminhtml_nominateinstructor_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
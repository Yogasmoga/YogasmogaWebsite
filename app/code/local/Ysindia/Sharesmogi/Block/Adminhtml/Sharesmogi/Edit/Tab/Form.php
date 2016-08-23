<?php

class Ysindia_Sharesmogi_Block_Adminhtml_Sharesmogi_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('sharesmogi_form', array('legend'=>Mage::helper('sharesmogi')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('sharesmogi')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('sharesmogi')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('sharesmogi')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('sharesmogi')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('sharesmogi')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('sharesmogi')->__('Content'),
          'title'     => Mage::helper('sharesmogi')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getSharesmogiData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSharesmogiData());
          Mage::getSingleton('adminhtml/session')->setSharesmogiData(null);
      } elseif ( Mage::registry('sharesmogi_data') ) {
          $form->setValues(Mage::registry('sharesmogi_data')->getData());
      }
      return parent::_prepareForm();
  }
}
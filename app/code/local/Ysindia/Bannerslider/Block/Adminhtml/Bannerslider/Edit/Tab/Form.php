<?php

class Ysindia_Bannerslider_Block_Adminhtml_Bannerslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('bannerslider_form', array('legend'=>Mage::helper('bannerslider')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bannerslider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('bannerslider')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('bannerslider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('bannerslider')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('bannerslider')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('link1', 'text', array(
          'name'      => 'link1',
          'label'     => Mage::helper('bannerslider')->__('Link1'),
          'title'     => Mage::helper('bannerslider')->__('Link1'),
          //'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
      $fieldset->addField('link2', 'text', array(
          'name'      => 'link2',
          'label'     => Mage::helper('bannerslider')->__('Link2'),
          'title'     => Mage::helper('bannerslider')->__('Link2'),
          //'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
      $fieldset->addField('text', 'editor', array(
          'name'      => 'text',
          'label'     => Mage::helper('bannerslider')->__('Content'),
          'title'     => Mage::helper('bannerslider')->__('Content'),
          'style'     => 'width:600px; height:100px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getBannersliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBannersliderData());
          Mage::getSingleton('adminhtml/session')->setBannersliderData(null);
      } elseif ( Mage::registry('bannerslider_data') ) {
          $form->setValues(Mage::registry('bannerslider_data')->getData());
      }
      return parent::_prepareForm();
  }
}
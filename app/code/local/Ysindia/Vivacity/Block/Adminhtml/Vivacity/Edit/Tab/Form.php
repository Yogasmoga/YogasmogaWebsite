<?php

class Ysindia_Vivacity_Block_Adminhtml_Vivacity_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vivacity_form', array('legend'=>Mage::helper('vivacity')->__('Item information')));
     
      $fieldset->addField('order_id', 'text', array(
          'label'     => Mage::helper('vivacity')->__('Order Id'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'order_id',
      ));

      $fieldset->addField('selected_size', 'text', array(
          'label'     => Mage::helper('vivacity')->__('Selected Size'),
          'required'  => false,
          'name'      => 'selected_size',
	  ));
		
    /*  $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('vivacity')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('vivacity')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('vivacity')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('vivacity')->__('Content'),
          'title'     => Mage::helper('vivacity')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
		*/
      if ( Mage::getSingleton('adminhtml/session')->getVivacityData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getVivacityData());
          Mage::getSingleton('adminhtml/session')->setVivacityData(null);
      } elseif ( Mage::registry('vivacity_data') ) {
          $form->setValues(Mage::registry('vivacity_data')->getData());
      }
      return parent::_prepareForm();
  }
}
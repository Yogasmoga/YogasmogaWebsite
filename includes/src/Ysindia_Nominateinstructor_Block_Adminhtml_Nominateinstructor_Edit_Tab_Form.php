<?php

class Ysindia_Nominateinstructor_Block_Adminhtml_Nominateinstructor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('nominateinstructor_form', array('legend'=>Mage::helper('nominateinstructor')->__('Item information')));
     
      $fieldset->addField('your_first_name', 'text', array(
          'label'     => Mage::helper('nominateinstructor')->__('First Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'your_first_name',
      ));

      /*$fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('nominateinstructor')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/
	  
	  $fieldset->addField('your_last_name', 'text', array(
          'label'     => Mage::helper('nominateinstructor')->__('Last Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'your_last_name',
      ));
	  $fieldset->addField('your_email', 'text', array(
          'label'     => Mage::helper('nominateinstructor')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'your_email',
      ));
	  
	  $fieldset->addField('instructor_first_name', 'text', array(
          'label'     => Mage::helper('nominateinstructor')->__('Instructer First Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'instructor_first_name',
      ));
	  $fieldset->addField('instructor_last_name', 'text', array(
          'label'     => Mage::helper('nominateinstructor')->__('Instructer Last Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'instructor_last_name',
      ));
	  $fieldset->addField('instructor_email', 'text', array(
          'label'     => Mage::helper('nominateinstructor')->__('Instructer Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'instructor_email',
      ));
	  
	  
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('nominateinstructor')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('nominateinstructor')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('nominateinstructor')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('nominateinstructor')->__('Content'),
          'title'     => Mage::helper('nominateinstructor')->__('Content'),
          'style'     => 'width:700px; height:300px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getNominateInstructorData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getNominateInstructorData());
          Mage::getSingleton('adminhtml/session')->setNominateInstructorData(null);
      } elseif ( Mage::registry('nominateinstructor_data') ) {
          $form->setValues(Mage::registry('nominateinstructor_data')->getData());
      }
      return parent::_prepareForm();
  }
}
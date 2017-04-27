<?php

class Ysindia_Events_Block_Adminhtml_Events_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('events_form', array('legend'=>Mage::helper('events')->__('Item information')));
     
      $fieldset->addField('date', 'date', array(
			'name'               => 'date',
			'label'              => Mage::helper('events')->__('Date'),
			'after_element_html' => '<small>Date Calender</small>',
			'tabindex'           => 1,
			'image'              => $this->getSkinUrl('images/grid-cal.gif'),
			'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
			'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                                  strtotime('next weekday') )
		));
	  $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('events')->__('Event Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
	  $fieldset->addField('start_at_time', 'text', array(
          'label'     => Mage::helper('events')->__('Time'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'start_at_time',
		  'after_element_html' => '<small>Note: 1-12 am or pm.</small>',
      ));
	  $fieldset->addField('function', 'text', array(
          'label'     => Mage::helper('events')->__('Instructor Name or Party'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'function',
      ));
/*
      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('events')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		*/
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('events')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('events')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('events')->__('Disabled'),
              ),
          ),
      ));
     /*
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('events')->__('Content'),
          'title'     => Mage::helper('events')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     */
      if ( Mage::getSingleton('adminhtml/session')->getEventsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEventsData());
          Mage::getSingleton('adminhtml/session')->setEventsData(null);
      } elseif ( Mage::registry('events_data') ) {
          $form->setValues(Mage::registry('events_data')->getData());
      }
      return parent::_prepareForm();
  }
}
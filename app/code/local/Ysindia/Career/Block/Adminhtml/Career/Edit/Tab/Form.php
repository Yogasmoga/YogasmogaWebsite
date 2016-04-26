<?php

class Ysindia_Career_Block_Adminhtml_Career_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('career_form', array('legend'=>Mage::helper('career')->__('Item information')));

      $fieldset->addField('job_state', 'select', array(
          'label'     => Mage::helper('career')->__('Job State'),
          'name'      => 'job_state',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('career')->__('California'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('career')->__('Connecticut'),
              ),
              array(
                  'value'     => 3,
                  'label'     => Mage::helper('career')->__('Massachusetts'),
              ),
              array(
                  'value'     => 4,
                  'label'     => Mage::helper('career')->__('New Jersey'),
              ),
              array(
                  'value'     => 5,
                  'label'     => Mage::helper('career')->__('New York'),
              ),
          ),
      ));


      $fieldset->addField('job_title', 'text', array(
          'label'     => Mage::helper('career')->__('Job Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'job_title',
      ));
      $fieldset->addField('available_position', 'text', array(
          'label'     => Mage::helper('career')->__('Available Position'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'available_position',
      ));


      $fieldset->addField('location', 'text', array(
          'label'     => Mage::helper('career')->__('Location'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'location',
      ));
      $fieldset->addField('reporting_to', 'text', array(
          'label'     => Mage::helper('career')->__('Reporting to'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'reporting_to',
      ));
      $fieldset->addField('working_with', 'text', array(
          'label'     => Mage::helper('career')->__('Working with'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'working_with',
      ));
      $fieldset->addField('type', 'text', array(
          'label'     => Mage::helper('career')->__('Type'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'type',
      ));
      $fieldset->addField('compensation', 'text', array(
          'label'     => Mage::helper('career')->__('Compensation'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'compensation',
      ));

      $fieldset->addField('job_posted', 'text', array(
          'label'     => Mage::helper('career')->__('Date Posted'),
          //'class'     => 'required-entry',
          'required'  => false,
          'name'      => 'job_posted',
      ));

      /*
      $dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
      $fieldset->addField('date_posted', 'date', array(
          'name'   => 'date_posted',
          'label'  => Mage::helper('career')->__('Date Posted'),
          'title'  => Mage::helper('career')->__('Date Posted'),
          'placeholder'=>Mage::helper('career')->__('Date Posted'),
          'image'  => $this->getSkinUrl('images/grid-cal.gif'),
          'input_format' => $dateFormatIso,
          'format'       => $dateFormatIso,
          'time' => true
      ));*/

      /*
      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('career')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		*/
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('career')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('career')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('career')->__('Disabled'),
              ),
          ),
      ));

      $fieldset->addField('introduction', 'editor', array(
          'name'      => 'introduction',
          'label'     => Mage::helper('career')->__('Introduction'),
          'title'     => Mage::helper('career')->__('Introduction'),
          'style'     => 'width:600px;height:200px;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      ));

      $fieldset->addField('responsibilities', 'editor', array(
          'name'      => 'responsibilities',
          'label'     => Mage::helper('career')->__('Responsibilities'),
          'title'     => Mage::helper('career')->__('Responsibilities'),
          'style'     => 'width:600px;height:200px;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      ));
      $fieldset->addField('desired_skill', 'editor', array(
          'name'      => 'desired_skill',
          'label'     => Mage::helper('career')->__('Desired Skills, Qualifications And Experience'),
          'title'     => Mage::helper('career')->__('Desired Skills, Qualifications And Experience'),
          'style'     => 'width:600px;height:200px;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      ));
      $fieldset->addField('how_to_apply', 'editor', array(
          'name'      => 'how_to_apply',
          'label'     => Mage::helper('career')->__('How To Apply'),
          'title'     => Mage::helper('career')->__('How To Apply'),
          'style'     => 'width:600px;height:200px;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      ));

      $fieldset->addField('about_ys', 'editor', array(
          'name'      => 'about_ys',
          'label'     => Mage::helper('career')->__('About YOGASMOGA'),
          'title'     => Mage::helper('career')->__('About YOGASMOGA'),
          'style'     => 'width:600px;height:200px;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      ));

      /*$fieldset->addField('how_to_apply', 'editor', array(
          'name'      => 'how_to_apply',
          'label'     => Mage::helper('career')->__('How To Apply'),
          'title'     => Mage::helper('career')->__('How To Apply'),
          'style'     => 'width:600px;height:200px;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'wysiwyg'   => true,
          'required'  => true,
      ));*/



      /*$fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('career')->__('Content'),
          'title'     => Mage::helper('career')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/

     
      if ( Mage::getSingleton('adminhtml/session')->getCareerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCareerData());
          Mage::getSingleton('adminhtml/session')->setCareerData(null);
      } elseif ( Mage::registry('career_data') ) {
          $form->setValues(Mage::registry('career_data')->getData());
      }
      return parent::_prepareForm();
  }
}
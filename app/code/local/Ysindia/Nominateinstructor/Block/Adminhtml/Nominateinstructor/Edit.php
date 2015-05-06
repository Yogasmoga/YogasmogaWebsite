<?php

class Ysindia_Nominateinstructor_Block_Adminhtml_Nominateinstructor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'nominateinstructor';
        $this->_controller = 'adminhtml_nominateinstructor';
        
        $this->_updateButton('save', 'label', Mage::helper('nominateinstructor')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('nominateinstructor')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('nominateinstructor_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'nominateinstructor_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'nominateinstructor_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('nominateinstructor_data') && Mage::registry('nominateinstructor_data')->getId() ) {
            return Mage::helper('nominateinstructor')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('nominateinstructor_data')->getTitle()));
        } else {
            return Mage::helper('nominateinstructor')->__('Add Item');
        }
    }
}
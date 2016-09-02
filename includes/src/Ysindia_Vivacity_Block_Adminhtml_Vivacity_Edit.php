<?php

class Ysindia_Vivacity_Block_Adminhtml_Vivacity_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'vivacity';
        $this->_controller = 'adminhtml_vivacity';
        
        $this->_updateButton('save', 'label', Mage::helper('vivacity')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('vivacity')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('vivacity_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'vivacity_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'vivacity_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('vivacity_data') && Mage::registry('vivacity_data')->getId() ) {
            return Mage::helper('vivacity')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('vivacity_data')->getTitle()));
        } else {
            //return Mage::helper('vivacity')->__('Add Item');
        }
    }
}
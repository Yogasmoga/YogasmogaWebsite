<?php

class Ysindia_Sharesmogi_Block_Adminhtml_Sharesmogi_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sharesmogi';
        $this->_controller = 'adminhtml_sharesmogi';
        
        $this->_updateButton('save', 'label', Mage::helper('sharesmogi')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('sharesmogi')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('sharesmogi_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'sharesmogi_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'sharesmogi_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('sharesmogi_data') && Mage::registry('sharesmogi_data')->getId() ) {
            return Mage::helper('sharesmogi')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('sharesmogi_data')->getTitle()));
        } else {
            return Mage::helper('sharesmogi')->__('Add Item');
        }
    }
}
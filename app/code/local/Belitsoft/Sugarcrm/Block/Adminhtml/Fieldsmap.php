<?php
/**
 * Adminhtml Belitsoft Sugarcrm fields map form block
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */

class Belitsoft_Sugarcrm_Block_Adminhtml_Fieldsmap extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'sugarcrm';
		$this->_controller = 'adminhtml_fieldsmap';

		$this->_addButtonLabel = Mage::helper('sugarcrm')->__('Add Fields Mapping');
		$this->_headerText = Mage::helper('sugarcrm')->__('Manage Fields Mapping');
		
		parent::__construct();
	}

	public function getCreateUrl()
	{
		return $this->getUrl('*/*/new', array('module'=>Mage::getSingleton('sugarcrm/connection')->getModuleName()));
	}
}
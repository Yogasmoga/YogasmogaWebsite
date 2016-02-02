<?php
/**
 * Adminhtml Belitsoft Sugarcrm errors
 *
 * @category   Belitsoft
 * @package	Belitsoft_Sugarcrm
 * @author	 Belitsoft <bits@belitsoft.com>
 */

class Belitsoft_Sugarcrm_Block_Adminhtml_Errors extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'sugarcrm';
		$this->_controller = 'adminhtml_errors';

		$this->_headerText = Mage::helper('sugarcrm')->__('Errors');

		parent::__construct();

		$this->removeButton('add');
	}
}
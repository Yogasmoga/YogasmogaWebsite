<?php
/**
 * Adminhtml Belitsoft Sugarcrm user opearations form block
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */

class Belitsoft_Sugarcrm_Block_Adminhtml_Operations extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'sugarcrm';
		$this->_controller = 'adminhtml';
		$this->_mode = 'operations';

		parent::__construct();

		$this->_removeButton('back');
		$this->_removeButton('reset');
		$this->_updateButton('save', 'label', $this->__('Save'));
		$this->_updateButton('save', 'id', $this->getSaveButtonId());
	}

	public function getHeaderText()
	{
		return $this->__('User Operations');
	}

	public function addFormScripts($js)
	{
		$this->_formScripts[] = $js;
	}

	/**
	 * Helper function to get save button id
	 *
	 * @return string Returns id.
	 */
	public function getSaveButtonId()
	{
		return 'save_button';
	}

    public function getHeaderCssClass()
    {
		return 'icon-head head-user';
    }
}
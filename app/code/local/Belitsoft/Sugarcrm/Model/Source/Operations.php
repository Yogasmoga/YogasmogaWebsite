<?php
/**
 * Mageplace Magento-Sugarcrm bridge
 *
 * @category	Belitsoft_Sugarcrm
 * @package		Belitsoft_Sugarcrm
 * @copyright	Copyright (c) 2011 Mageplace. (http://www.mageplace.com)
 * @license		http://www.mageplace.com/disclaimer.html
 */

class Belitsoft_Sugarcrm_Model_Source_Operations extends Belitsoft_Sugarcrm_Model_Source_Abstract
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'save',	'label' => Mage::helper('sugarcrm')->__('Save')),
			array('value' => 'delete',	'label' => Mage::helper('sugarcrm')->__('Delete')),
		);
	}
}

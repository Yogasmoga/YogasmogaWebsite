<?php
/**
 * SugarCRM Fieldsmap Model
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */
class Belitsoft_Sugarcrm_Model_Fieldsmap extends Mage_Core_Model_Abstract
{
	protected function _construct()
	{
		parent::_construct();

		$this->_init('sugarcrm/fieldsmap');
	}
}

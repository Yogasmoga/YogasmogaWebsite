<?php
/**
 * SugarCRM user operation resourse model
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */
class Belitsoft_Sugarcrm_Model_Mysql4_Operations extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct()
	{
		$this->_init('sugarcrm/user_operations', 'id');
	}

	function truncate() {
		$this->_getWriteAdapter()->truncate($this->getMainTable());
	}
}

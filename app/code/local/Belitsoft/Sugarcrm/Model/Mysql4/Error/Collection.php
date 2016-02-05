<?php
/**
 * Sugarcrm Error collection
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */
class Belitsoft_Sugarcrm_Model_Mysql4_Error_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	protected function _construct()
	{
		$this->_init('sugarcrm/error');
	}

	public function addOperationFilter($operation)
	{
		$operation = (string)$operation;
		
		$this->getSelect()->where('main_table.operation LIKE ?', '%'.$operation.'%');
		
		return $this;
	}
}
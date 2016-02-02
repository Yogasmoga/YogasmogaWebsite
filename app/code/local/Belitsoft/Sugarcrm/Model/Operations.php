<?php
/**
 * SugarCRM User Operations Model
 *
 * @category   Belitsoft
 * @package    Belitsoft_Sugarcrm
 * @author     Belitsoft <bits@belitsoft.com>
 */
class Belitsoft_Sugarcrm_Model_Operations extends Mage_Core_Model_Abstract
{
	protected function _construct()
	{
		parent::_construct();

		$this->_init('sugarcrm/operations');
	}

	/**
	 * Set operation item
	 *
	 * @return Belitsoft_Sugarcrm_Model_Operations
	 */
	public function setOperationItem($bean, $operation, $enable)
	{
		$this->setData('bean', $bean);
		$this->setData('operation', $operation);
		$this->setData('enable', $enable);
		
		return $this;
	}
    
	/**
	 * Get SugarBeans array
	 *
	 * @return array
	 */
	public function getBeansArray()
	{
		$_beans = Mage::getSingleton('sugarcrm/config')->getBeans();
		$result = array();
		foreach ($_beans as $bean => $info) {
			$result[$bean] = $info['label'];
		}
		
		return $result;
	}
	
	/**
	 * Get user operations
	 *
	 * @return array
	 */
	public function getOperationsArray()
	{
		$_opers = Mage::getSingleton('sugarcrm/config')->getUserOperations();
		$result = array();
		foreach ($_opers as $oper => $info) {
			$result[$oper] = $info['label'];
		}
		
		return $result;
	}
	
	
	/**
	 * Get enabled operations
	 *
     * @param	string	$operation_type	Operation name
	 * @return	array
	 */
	public function getEnabledOperations($operation_type=null)
	{
		$bean_operations = array();
		$collection = Mage::getResourceModel('sugarcrm/operations_collection')->load();
		foreach($collection as $attribute) {
			$data = $attribute->getData();
			if(!empty($operation_type) && is_string($operation_type)) {
				if($data['operation'] == $operation_type) {
					$bean_operations[$data['bean']] = $data['enable'];
				}
			} else {
				$bean_operations[$data['bean']][$data['operation']] = $data['enable'];
			}
		}
				
		return $bean_operations;
	}
	

	public function truncate()
	{
		$this->_getResource()->truncate();
	}
}
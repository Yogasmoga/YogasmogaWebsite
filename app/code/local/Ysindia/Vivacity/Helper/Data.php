<?php

class Ysindia_Vivacity_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function saveData($orderId,$size)
	{
		
		
		$resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
		
		
		$query = 'SELECT order_id FROM vivacity where order_id=' . $orderId;

        $row = $readConnection->fetchAll($query);

        if ($row) {
			;
		}
		else{
			$model = Mage::getModel('vivacity/vivacity');
			$model->setOrderId($orderId);
			$model->setSelectedSize($size);
			$model->setCreatedTime(date('Y-m-d h:i:s'));
			$model->save();
		}
	}	
}
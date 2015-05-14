<?php 

class Ysindia_Nominateinstructor_Block_Adminhtml_Renderer_CustomerName extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        if ($row->getData('your_first_name') != NULL || $row->getData('your_last_name') != NULL ) {
			$firstName = $row->getData('your_first_name');
	        $lastName = $row->getData('your_last_name');
			if ($lastName != NULL) {
				return $firstName . ' ' . $lastName;
	                } else {
				return $firstName;
			}
	        } else {
        		return Mage::helper('nominateinstructor')->__('NO NAME ASSIGNED');
	        }
    }
}
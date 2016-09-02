<?php 

class Ysindia_Nominateinstructor_Block_Adminhtml_Renderer_InstructorName extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        if ($row->getData('instructor_first_name') != NULL || $row->getData('instructor_last_name') != NULL ) {
			$firstName = $row->getData('instructor_first_name');
	        $lastName = $row->getData('instructor_last_name');
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
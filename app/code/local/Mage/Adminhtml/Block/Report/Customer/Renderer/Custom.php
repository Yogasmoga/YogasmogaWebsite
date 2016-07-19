<?php
class Mage_Adminhtml_Block_Report_Customer_Renderer_Custom extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
    public function render(Varien_Object $row) {
        $id =  $row['customer_id'];

        $customerShippingAddressId = Mage::getModel('customer/customer')->load($id)->getDefaultShipping();
        $defaultShippingAddress = Mage::getModel('customer/address')->load($customerShippingAddressId); //address as object
        $defaultShippingAddress = $defaultShippingAddress->getData(); //return as array
        return $defaultShippingAddress['region'];
    }
}
?>
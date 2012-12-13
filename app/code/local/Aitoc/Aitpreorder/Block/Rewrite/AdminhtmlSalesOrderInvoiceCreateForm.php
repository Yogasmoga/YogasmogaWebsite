<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AdminhtmlSalesOrderInvoiceCreateForm.data.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ qCCYgmMDajrpIcaD('d3b09aebe1b03903cfae8df91080d781'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_AdminhtmlSalesOrderInvoiceCreateForm extends Mage_Adminhtml_Block_Sales_Order_Invoice_Create_Form
{
   public function hasInvoiceShipmentTypeMismatch() {
        $result = parent::hasInvoiceShipmentTypeMismatch();
        if(!$result)
        {
            $order=$this->getOrder(); 
            $havepreorder=Mage::helper('aitpreorder')->IsHavePreorder($order);
            
            if($havepreorder)
            {
                $result=true;
            }
                   
        }
        return $result;
    }
       
} } 
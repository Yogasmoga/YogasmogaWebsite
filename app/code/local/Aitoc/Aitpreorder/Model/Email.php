<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Model/Email.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ qCCYgmMDajrpIcaD('11f10bc75b19be7ecea3d9c1f8236013'); ?><?php
/**
 * @copyright  Copyright (c) 2012 AITOC, Inc. 
 */
class Aitoc_Aitpreorder_Model_Email extends Mage_ProductAlert_Model_Email
{ 
    protected function _getStockBlock()
    {
        if (is_null($this->_stockBlock)) {
            $this->_stockBlock = Mage::helper('productalert')
                ->createBlock('aitpreorder/email_stock');
        }
		return $this->_stockBlock;
    }
} } 
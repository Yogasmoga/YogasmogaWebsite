<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/BundleAdminhtmlSalesOrderViewItemsRenderer.data.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ phhSMymjZeaocCZj('d8e3179edbab31e7f4c15fb372fe8209'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_BundleAdminhtmlSalesOrderViewItemsRenderer extends Mage_Bundle_Block_Adminhtml_Sales_Order_View_Items_Renderer
{
    public function getValueHtml($item)
    {
        $product = Mage::getModel('catalog/product');
        
//	$product->setStoreId($item->getOrder()->getStoreId());
        /*
         * * Aitoc fix for bug 'unable to ship or invoice bundle product'
         */
        $product->setStoreId($item->getStoreId());
        
	$product->load($item->getData('product_id'));

        return parent::getValueHtml($item) . ($product->getPreorder() ? "<input type=hidden class='bundlepreorder' />" : '');
    }
} } 
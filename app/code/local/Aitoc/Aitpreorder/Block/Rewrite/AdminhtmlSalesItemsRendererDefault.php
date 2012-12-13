<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AdminhtmlSalesItemsRendererDefault.data.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ qCCYgmMDajrpIcaD('17255e029f0142cf5eee54afe46c90f5'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_AdminhtmlSalesItemsRendererDefault extends Mage_Adminhtml_Block_Sales_Items_Renderer_Default
{




  public function getColumnHtml(Varien_Object $item, $column, $field = null)
    {
            $str="";$sku="";
            if($column=='name') 
            {
                $orderItemDataS=$item->getOrderItem()->getData('product_options');
                if($item->getOrderItem()->getData('product_type')=='grouped')
                {
                    $product=Mage::getModel('catalog/product')->load($item->getOrderItem()->getData('product_id'));
                    $sku=$product->getSku();  
                }
                else
                {                
                    $orderItemData=unserialize($orderItemDataS);
                    $itemdata=$item->getData();
                    if(isset($orderItemData['simple_sku']))
                    {
                        $sku=$orderItemData['simple_sku'];
                    }
                    elseif(isset($itemdata['sku']))
                    {
                        $sku=$itemdata['sku'];
                    }
                }
                if($sku!="")
                    {                
                        $str='<input type="hidden" id="preordersku" value="'.$sku.'">';  
                    }
                                    
            }
            return parent::getColumnHtml($item, $column, $field).$str;
    }
    




} } 
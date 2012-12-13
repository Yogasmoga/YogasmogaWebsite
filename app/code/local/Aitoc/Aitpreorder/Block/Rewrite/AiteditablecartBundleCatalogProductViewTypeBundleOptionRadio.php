<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/AiteditablecartBundleCatalogProductViewTypeBundleOptionRadio.data.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ hccSBMgZrDkqUIrZ('7a4179b4a9eab78d21491b1ab6e69810'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_AiteditablecartBundleCatalogProductViewTypeBundleOptionRadio extends Aitoc_Aiteditablecart_Block_BundleCatalogProductViewTypeBundleOptionRadio                                          
{
    public function getSelectionTitlePrice($_selection, $includeContainer = true)
    {
        $addinf='';
        $_product = Mage::getModel('catalog/product')->load($_selection->getId());
        if($_product->getPreorder()==1)
        {
            $addinf=__('Pre-Order');
        }
        return parent::getSelectionTitlePrice($_selection, $includeContainer = true).'  <span class="price-notice">'.$addinf.'</span>';  
    } 
 
} } 
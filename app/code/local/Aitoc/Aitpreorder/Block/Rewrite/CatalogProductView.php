<?php
/**
 * Product:     Pre-Order
 * Package:     Aitoc_Aitpreorder_1.1.25_398049
 * Purchase ID: GFmKN376RqwlXbrxLFev6fwkrQkQ4sDnXgpK7XouBr
 * Generated:   2012-10-12 17:01:01
 * File path:   app/code/local/Aitoc/Aitpreorder/Block/Rewrite/CatalogProductView.data.php
 * Copyright:   (c) 2012 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'Aitoc_Aitpreorder')){ wffYkarOdWjhXAeg('834630676e6a28094714d33b719ea212'); ?><?php
/**
* @copyright  Copyright (c) 2009 AITOC, Inc. 
*/

class Aitoc_Aitpreorder_Block_Rewrite_CatalogProductView extends Mage_Catalog_Block_Product_View
{
    protected function _toHtml()
    {          
        if(($this->getNameInLayout()=='product.info') && $this->getProduct()->getPreorder())
        {
            $result=parent::_toHtml();
            $descript=$this->getProduct()->getPreorderdescript();
            if($descript=="")
            {
                $descript=$this->__('Pre-Order');
            }
            $result=str_ireplace($this->__('In stock')," ".$descript,$result);
            $result=str_ireplace($this->__('Out stock')," ".$this->__('not Available'),$result);
            return($result);
        }
        elseif($this->getNameInLayout()=='product.info.addtocart' && $this->getProduct()->getPreorder())
        {
            $result=str_replace($this->__('Add to Cart'), $this->__('Pre-Order'), parent::_toHtml());   
            return $result;
        }
        else
        { 
            return (parent::_toHtml());
        }
    }
} } 
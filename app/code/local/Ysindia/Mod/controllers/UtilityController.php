<?php

class Ysindia_Mod_UtilityController extends Mage_Core_Controller_Front_Action
{
    // for bundle gift set
    public function citytimeAction()
    {
        $city_times = $this->getRequest()->getParam('city_times');

        if(isset($city_times)){

            $times = array();

            $ar_city_times = explode(",", $city_times);

            foreach($ar_city_times as $city_time) {

                $timestamp = strtotime($city_time);

                $time = date('h:i A', $timestamp);

                $times[] = $time;
            }

            echo json_encode(array('message'=>'found', 'times' => $times));
        }
        else
            echo json_encode(array('message'=>'none'));
    }

    public function getcombodataAction(){

        $bundledIds = $this->getRequest()->getParam('ids');

        $ar_bundled_product_ids = explode(",", $bundledIds);            // 23:56,56:67 etc.

        $arBundledData = array();
        foreach($ar_bundled_product_ids as $product_color_id) {

            $ar_id_color_code = explode(":", $product_color_id);          // id:color_code
            $product_id = $ar_id_color_code[0];
            $bundle_color_id = $ar_id_color_code[1];

            $_bundle_product = Mage::getModel('catalog/product')->load(intval($product_id));
            $bundledProductUrl = $_bundle_product->getProductUrl() . '?color=' . $bundle_color_id;

            $_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_bundle_product);

            $ar_child_sizes = array();
            foreach ($_childProducts as $_childProduct) {
                $size = $_childProduct->getAttributeText('size');

                if(is_numeric($size) && intval($size)>12)
                    continue;

                if(strpos(strtoupper($size), "T")!==false)
                    continue;

                if (is_numeric($size))
                    $ar_child_sizes[] = intval($size);
                else
                    $ar_child_sizes[] = $size;
            }

            $ar_child_sizes = array_unique($ar_child_sizes);

            $_gallery = Mage::getModel('catalog/product')->load($_bundle_product->getId())->getMediaGalleryImages();
            $arImages = array();
            if (isset($_gallery)) {

                foreach ($_gallery as $_image) {
                    $imageLabelData = json_decode(trim($_image->getLabel()), true);

                    if ($imageLabelData == NULL || strcasecmp($imageLabelData['type'], "product image") != 0)
                        continue;

                    $colorCode = $imageLabelData['color'];

                    if($colorCode != $bundle_color_id)
                        continue;

                    //$image = (string)Mage::helper('catalog/image')->init($_bundle_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(450, 450);
                    $image = (string)Mage::helper('adaptiveResize/image')->init($_bundle_product, 'thumbnail', $_image->getFile())->setCropPosition('top')->adaptiveResize(320);

                    $arImages[] = $image;
                }

                if(count($arImages)>0)
                    $default_image = $arImages[0];
                else
                    $default_image = "";
            }

            $arBundledData[] = array(
                "id" => $product_id,
                "color_code" => $bundle_color_id,
                "name" => $_bundle_product->getName(),
                "url" => $bundledProductUrl,
                "description" => $_bundle_product->getDescription(),
                "price" => "$" . round($_bundle_product->getPrice(),2),
                "sizes" => implode(",", $ar_child_sizes),
                "default_image" => $default_image,
                "images" => $arImages
            );
        }

        if(count($arBundledData)>0)
            echo json_encode(array("message" => "found", "data" => $arBundledData));
        else
            echo json_encode(array("message" => "empty"));
    }
}
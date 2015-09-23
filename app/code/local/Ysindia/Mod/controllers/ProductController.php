<?php

class Ysindia_Mod_ProductController extends Mage_Core_Controller_Front_Action
{
    public function productcolorsAction()
    {
        $colors = array();

        $sizes = array();

        $storeId = Mage::app()->getStore()->getStoreId();

        $id = $this->getRequest()->getParam('id');

        $_product = Mage::getModel('catalog/product')->load($id);
        $_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);

        foreach ($_childProducts as $_childProduct) {

            $colorAttributeValue = $_childProduct->getAttributeText('color');

            if (strpos($colorAttributeValue, "|") !== FALSE) {

                $arColor = explode("|", $colorAttributeValue);
                $colorName = $arColor[0];
                $colorHex = $arColor[1];
                $colorCode = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childProduct->getId(), 'color', $storeId);
            }

            $size = $_childProduct->getAttributeText('size');
            $quantity = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childProduct)->getQty();

            if (!$quantity)
                $quantity = 0;

            $colors[$colorCode] = array(
                'name' => $colorName,
                'hex' => $colorHex,
                'code' => $colorCode,
            );

            if (!isset($sizes[$colorCode . "_" . $size]))
                $sizes[$colorCode . "_" . $size] = array('colorCode' => $colorCode, 'size' => $size, 'quantity' => $quantity);
        }

        $arSizes = array();
        foreach ($sizes as $key => $row)
            $arSizes[$key] = $row['size'];

        array_multisort($arSizes, SORT_ASC, $sizes);

        $arColors = array();

        foreach ($colors as $color) {

            $arSizes = array();

            $colorCode = $color['code'];

            foreach ($sizes as $size) {

                if ($size['colorCode'] == $colorCode) {

                    $arSizes[] = array('size' => $size['size'], 'quantity' => intval($size['quantity']));
                }
            }

            $arColors[] = array('colorCode' => $color['code'], 'colorName' => $color['name'], 'colorHex' => $color['hex'], 'sizes' => $arSizes);
        }

        echo json_encode(array('colors' => $arColors));
    }

    public function productcolorimagesAction()
    {

        $id = $this->getRequest()->getParam('id');

        $_product = Mage::getModel('catalog/product')->load($id);
        $_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product);

        $_gallery = Mage::getModel('catalog/product')->load($_product->getId())->getMediaGalleryImages();

        foreach ($_childProducts as $_childProduct) {

            $colorAttributeValue = $_childProduct->getAttributeText('color');
            if (strpos($colorAttributeValue, "|") !== FALSE) 
                $colorCode = Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childProduct->getId(), 'color', $storeId);

            if(!isset($colorCode))
                continue;
            
            foreach ($_gallery as $_image) {

                $imageLabelData = json_decode(trim($_image->getLabel()), true);
                if ($imageLabelData == NULL || strcasecmp($imageLabelData['type'], "product image") != 0)
                    continue;
                if ($imageLabelData['color'] == Mage::getResourceModel('catalog/product')->getAttributeRawValue($_childProduct->getId(), 'color', Mage::app()->getStore()->getStoreId())) {
                    $alt = "";
                    if (isset($imageLabelData['alt']))
                        $alt = $imageLabelData['alt'];

                    $smallImageUrl = Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(138, 180)->setQuality(90) . "|" . $alt;
                    $imageUrl = Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(771, 700)->setQuality(90) . "|" . $alt;
                    $zoomImageUrl = Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->setQuality(90) . "|" . $alt;

                    $imagePath = substr($zoomImageUrl, 1);
                    $dirImg = Mage::getBaseDir() . str_replace("/", DS, strstr($imagePath, '/media'));
                    if (file_exists($dirImg)) {
                        $imageObj = new Varien_Image($dirImg);
                        $width = $imageObj->getOriginalWidth();
                        $height = $imageObj->getOriginalHeight();

                        $zoomImageUrl .= "|" . $width . "|" . $height;
                    }

                    if (!isset($colorImages[$colorCode]["small"])) {
                        $colorImages[$colorCode] = array();
                        $colorImages[$colorCode]["small"] = array($smallImageUrl);
                        $colorImages[$colorCode]["zoom"] = array($zoomImageUrl);
                        $colorImages[$colorCode]["big"] = array($imageUrl);
                    }
                    else {
                        if (count($colorImages[$colorCode]["small"]) < 4) {
                            array_push($colorImages[$colorCode]["big"], $imageUrl);
                            array_push($colorImages[$colorCode]["small"], $smallImageUrl);
                            array_push($colorImages[$colorCode]["zoom"], $zoomImageUrl);
                        }
                    }

                }
            }
        }

        echo json_encode(array('colorImages' => $colorImages));
    }
}

?>
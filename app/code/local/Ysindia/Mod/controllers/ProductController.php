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

            if(!$quantity)
                $quantity = 0;

            $colors[$colorCode] = array(
                'name' => $colorName,
                'hex' => $colorHex,
                'code' => $colorCode,
            );

            if(!isset($sizes[$colorCode . "_" . $size]))
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

            $arColors[] = array('colorCode' => $color['code'], 'colorName' => $color['name'], 'colorHex' => $color['hex'], 'size' => $arSizes);
        }

        echo json_encode($arColors);
    }
}
?>
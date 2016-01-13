<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 3000);

require '../app/Mage.php';
Mage::app();

/***************** get all colors from database ***********************/
$allColors = array();
$productCollection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));

/* get all colors from database ******/
$allColors = array();
$allColorsNames = array();
$allColorAttribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color'); //here, "color" is the attribute_code
$allColorOptions = $allColorAttribute->getSource()->getAllOptions(true, true);
foreach ($allColorOptions as $instance) {
    if (!array_key_exists($instance['value'], $allColors)) {
        $allColors[$instance['value']] = $instance['label'];
        $allColorsNames[$instance['label']] = $instance['value'];
    }
}


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=live-site-products.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array(
    'SKU',
    'Name',
    'URL',
    'Availability',
    'Price',
    'Color',
    'Size'
));

/***************** get all colors from database end ***********************/

$arWomenCategory = array(3, 6, 7, 8, 16, 71, 43, 59, 65);
$arMenCategory = array(5, 10, 11, 12, 19);
$count = 0;
$_helper = Mage::helper('catalog/output');
foreach ($productCollection as $_product) {
    $product = Mage::getModel('catalog/product')->load($_product->getId());


    if (!isset($product) || !is_object($product) || !$product->getId()) {
        ;
    } else {
        if ($product->getTypeId() == 'configurable') {

            $forHidden = $product->getAttributeText('hidden_product');
            if (isset($forHidden) && strtolower($forHidden) == "yes")
                continue;

            $configurableProduct = $product;


            $_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $configurableProduct);

            foreach ($_childProducts as $_childProduct) {
				 $forHidden = $_childProduct->getAttributeText('hidden_product');
            if (isset($forHidden) && strtolower($forHidden) == "yes")
                continue;
                $buy_url = $configurableProduct->getUrlInStore();
                $price = round($configurableProduct->getPrice(), 2);
                $sku = $_childProduct->getSku();

                $size = $_childProduct->getAttributeText('size');

                $color = $_childProduct->getAttributeText('color');
                $color = substr($color, 0, strpos($color, "|"));
                $colorCode = $allColorsNames[$color];

                $productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childProduct);
                $stock = $productStock->getQty();
                $inStock = $productStock->getIsInStock();
                if ($stock <= 0 || !$inStock)
                    $available = 0;
                else
                    $available = $stock;

                $name = $_childProduct->getName();
                $buy_url = $buy_url . "?color=" . $colorCode;

                $arr = array(
                    $sku,
                    $name,
                    $buy_url,
                    $available,
                    $price,
                    $color,
                    $size,
                );

               fputcsv($output, $arr);
            }
        }
    }
}
?>
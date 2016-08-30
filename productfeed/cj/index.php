<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 3000);

require '../../app/Mage.php';
Mage::app();


$fileOut = fopen(Mage::getBaseDir() . "/var/productfeed/cjresult.txt", "w");

fwrite($fileOut, "&CID=4521127\n");
fwrite($fileOut, "&SUBID=171706\n");
fwrite($fileOut, "&PROCESSTYPE=UPDATE\n");
fwrite($fileOut, "&AID=12186878\n");
fwrite($fileOut, "&PARAMETERS=NAME|KEYWORDS|DESCRIPTION|SKU|BUYURL|AVAILABLE|IMAGEURL|PRICE|UPC|ADVERTISERCATEGORY|MERCHANDISETYPE\n");



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



/***************** get all colors from database end ***********************/

$arWomenCategory = array(3, 6, 7, 8, 16, 71, 43, 59, 65);
$arMenCategory = array(5, 10, 11, 12, 19);
$count = 0;
$_helper = Mage::helper('catalog/output');
foreach ($productCollection as $_product) {

    $description = $_helper->productAttribute($_product, $_product->getDescription(), 'description');

    $product = Mage::getModel('catalog/product')->load($_product->getId());

    $keywords = $product->getMetaKeyword();
    $keywordsValue = $keywords;
    if($keywordsValue == ''){
        $keywordsValue = 'No Keywords';
    }


    if (!isset($product) || !is_object($product) || !$product->getId()) {
        ;
    }
    else {
        if ($product->getTypeId() == 'configurable') {

            $forHidden = $product->getAttributeText('hidden_product');
            if (isset($forHidden) && strtolower($forHidden) == "yes")
                continue;

            $configurableProduct = $product;

            $sku_configurable = $configurableProduct->getSku();

            $_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $configurableProduct);

            $advertise_category = 'yoga apparel';
            $merchandiseType = 'Commissionable Items';


            $categoryIds = $product->getCategoryIds();


            if (isset($categoryIds) && is_array($categoryIds) && count($categoryIds) > 0) {
                foreach ($categoryIds as $id) {

                    if (intval($id) === 43 || intval($id) === 12 || intval($id) === 8) {
                        $merchandiseType = "Non-commissionable Items";
                        break;
                    }
                }
            } else
                continue;

            unset($categoryIds);

            $_gallery = Mage::getModel('catalog/product')->load($configurableProduct->getId())->getMediaGalleryImages();

            foreach ($_childProducts as $_childProduct) {

                $buy_url = $configurableProduct->getUrlInStore();

                $price = round($configurableProduct->getPrice(), 2);
                $sku = $_childProduct->getSku();
                $description = $_helper->productAttribute($configurableProduct, $configurableProduct->getDescription(), 'description');

                $size = $_childProduct->getAttributeText('size');

                $color = $_childProduct->getAttributeText('color');

                $color = substr($color, 0, strpos($color, "|"));

                $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')
                    ->getParentIdsByChild($_childProduct->getId());
                $configurableProduct = Mage::getModel('catalog/product')->load($parentIds[0]);




                $colorCode = $allColorsNames[$color];

                $productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childProduct);
                $stock = $productStock->getQty();
                $inStock = $productStock->getIsInStock();
                if ($stock <= 0 || !$inStock)
                    $available = 'NO';
                else
                    $available = 'YES';


                if (isset($_gallery)) {

                    foreach ($_gallery as $_image) {
                        $imageLabelData = json_decode(trim($_image->getLabel()), true);

                        if ($imageLabelData == NULL || strcasecmp($imageLabelData['type'], "product image") != 0)
                            continue;

                        $productColorCode = $imageLabelData['color'];

                        if ($colorCode != $productColorCode)
                            continue;

                        //$image_url = (string)Mage::helper('catalog/image')->init($configurableProduct, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(225, 364)->setQuality(91);
                        $image_url = (string)Mage::helper('catalog/image')->init($configurableProduct, 'thumbnail', $_image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(450, 728)->setQuality(91);
                        break;
                    }
                }



                $age_group = "Adult";
                $upc = $sku;

                $total_name = html_entity_decode($configurableProduct->getName());
                $name = $total_name.' - '.ucwords($color);
                //$name = $total_name;
                $total_buy_url = $buy_url . "?color=" . $colorCode;

                $data = "$name|$keywordsValue|$description|$sku|$total_buy_url|$available|$image_url|$price|$upc|$advertise_category|$merchandiseType\n";

                fwrite($fileOut, $data);


            }
        }
    }
}
fclose($fileOut);
/*
$root = "ysmaster.dev";
$file_url = "http://$root/var/productfeed/cjresult.txt";
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
readfile($file_url);
*/
echo "<br/><br/>Product feed ready, <a href='download.php'>click here</a> to download";
?>
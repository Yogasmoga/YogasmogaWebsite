<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 3000);

require '../../app/Mage.php';
Mage::app();

$fileIn = fopen("products.csv", "r");
$fileOut = fopen(Mage::getBaseDir() . "/var/productfeed/result.txt", "w");

fwrite($fileOut, "&CID=4521127\n");
fwrite($fileOut, "&SUBID=171706\n");
fwrite($fileOut, "&PROCESSTYPE=UPDATE\n");
fwrite($fileOut, "&AID=12186878\n");
fwrite($fileOut, "&PARAMETERS=NAME|KEYWORDS|DESCRIPTION|SKU|BUYURL|AVAILABLE|IMAGEURL|PRICE|UPC|ADVERTISERCATEGORY|MERCHANDISETYPE\n");

$productCollection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('type_id', 'configurable')->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
$_helper = Mage::helper('catalog/output');

$count = 0;
foreach ($productCollection as $_product) {

    $product = Mage::getModel('catalog/product')->load($_product->getId());

/*
    $ar = fgetcsv($fileIn);
    if (++$count == 1)
        continue;

    $sku = $ar[0];
    $name = $ar[1];

    //$pos = strrpos($name, '-');
    //$name = substr($name, 0, $pos);

    $price = $ar[2];
    $description = trim($ar[3]);
    $available = $ar[4] === "1" ? 'YES' : 'NO';
    $keyword = '';
    $buy_url = '';
    $image_url = '';
    $advertise_category = 'yoga apparel';
    $merchandiseType = '';
*/

    if ($product->getTypeId() == 'configurable') {

        $sku = $product->getSku();
        $name = $product->getName();
        $price = round($product->getPrice(), 2);
        $description = $_helper->productAttribute($product, $product->getDescription(), 'description');
        $description = trim(preg_replace('/\s+/', ' ', $description));

        $productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
        $stock = $productStock->getQty();
        $inStock = $productStock->getIsInStock();
        if ($stock <= 0 || !$inStock)
            $available = 'NO';
        else
            $available = 'YES';

        $keyword = '';
        $buy_url = '';
        $image_url = '';
        $advertise_category = 'yoga apparel';
        $merchandiseType = '';

        $forHidden = $product->getAttributeText('hidden_product');
        if (isset($forHidden) && strtolower($forHidden) == "yes")
            continue;

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

        $buy_url = $product->getUrlInStore();
        $keywords = $product->getMetaKeyword();

        $images = Mage::getModel('catalog/product')->load($product->getId())->getMediaGalleryImages();

        if (isset($images) && count($images) > 0) {
            foreach ($images as $image) {

                $imgdata = json_decode(trim($image->getLabel()), true);
                if (isset($imgdata['type']) && $imgdata['type'] == 'product image') {
                    $image_url = (string)Mage::helper('catalog/image')->init($product, 'thumbnail', $image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(771, 700)->setQuality(91);
                    break;
                }
            }
        }

        $sku = str_replace('.', '-', $sku);
        $upc = $sku;

        $data = "$name|$keywords|$description|$sku|$buy_url|$available|$image_url|$price|$upc|$advertise_category|$merchandiseType\n";

        fwrite($fileOut, $data);
    }

}

fclose($fileOut);

echo "<br/><br/>Product feed ready, <a href='download.php'>click here</a> to download";
?>
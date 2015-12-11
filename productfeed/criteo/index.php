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

$productCollection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
$_helper = Mage::helper('catalog/output');

$count = 0;
foreach ($productCollection as $_product) {

    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);

    $sku = $product->getSku();
    $name = $product->getName();
    $price = round($product->getPrice(), 2);
    $description = $_helper->productAttribute($configurableProduct, $configurableProduct->getDescription(), 'description');

    $productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childProduct);
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
    $description = trim(preg_replace('/\s+/', ' ', $description));

    if (!isset($product) || !is_object($product) || !$product->getId()) {
        ;//echo "Bad product = $name ( $sku ) <br/>";
    } else {
        if ($product->getTypeId() == 'configurable') {

            $forHidden = $product->getAttributeText('hidden_product');
            if (isset($forHidden) && strtolower($forHidden) == "yes")
                continue;
            /*
                        $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')
                            ->getParentIdsByChild($product->getId());

                        if (!isset($parentIds) || count($parentIds) == 0)
                            continue;
            */
            $configurableProduct = $product; //Mage::getModel('catalog/product')->load($parentIds[0]);

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

            $buy_url = $configurableProduct->getUrlInStore();
            $keywords = $configurableProduct->getMetaKeyword();

            $images = Mage::getModel('catalog/product')->load($configurableProduct->getId())->getMediaGalleryImages();

            if (isset($images) && count($images) > 0) {
                foreach ($images as $image) {

                    $imgdata = json_decode(trim($image->getLabel()), true);
                    if (isset($imgdata['type']) && $imgdata['type'] == 'product image') {
                        //$image_url = (string)Mage::helper('catalog/image')->init($configurableProduct, 'thumbnail', $image->getFile());
                        $image_url = (string)Mage::helper('catalog/image')->init($configurableProduct, 'thumbnail', $image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(225, 364)->setQuality(91);
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
}

fclose($fileOut);

echo "<br/><br/>Product feed ready, <a href='download.php'>click here</a> to download";
?>
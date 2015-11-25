<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 3000);

require '../../app/Mage.php';
Mage::app();

$fileIn = fopen("products.csv", "r");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=google_feed.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array(
    'Id',
    'Title',
    'Description',
    'google product category',
    'Link',
    'Image link',
    'Condition',
    'Availability',
    'Price',
    'Sale price',
    'Sale price effective date',
    'Brand',
    'MPN',
    'Gender',
    'Age group',
    'Size'
));

$womenCategory = 3;
$womenCategory = 5;
$count = 0;

while (!feof($fileIn)) {

    $ar = fgetcsv($fileIn);
    if (++$count == 1)
        continue;

    $sku = $ar[0];
    $name = $ar[1];
	
	$pos = strrpos($name, '-');
	$name = substr($name, 0, $pos);
    $size = substr($pos+1);
	
    $price = $ar[2];
    $description = trim($ar[3]);
    $available = $ar[4] === "1" ? 'in stock' : 'out of stock';
    $keyword = '';
    $buy_url = '';
    $image_url = '';

    $description = trim(preg_replace('/\s+/', ' ', $description));

    $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);


    if (!isset($product) || !is_object($product) || !$product->getId()) {
        ;
    } else {
        if ($product->getTypeId() == 'configurable') {

            $forHidden = $product->getAttributeText('hidden_product');
            if (isset($forHidden) && strtolower($forHidden) == "yes")
                continue;

            $configurableProduct = $product;

            $categoryIds = $product->getCategoryIds();

            if (isset($categoryIds) && is_array($categoryIds) && count($categoryIds) > 0) {
                foreach ($categoryIds as $id) {
                    if (intval($id) === $womenCategory)
                        $gender = "female";
                    else if (intval($id) === $menCategory)
                        $gender = "male";
                }
            } else
                continue;

            unset($categoryIds);

            $buy_url = $configurableProduct->getUrlInStore();
            $keywords = $configurableProduct->getMetaKeyword();
            $price = round($configurableProduct->getPrice(),2);

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

            //$data = "$name|$keywords|$description|$sku|$buy_url|$available|$image_url|$price|$upc|$advertise_category|$merchandiseType\n";
			//array('id','title','description','google product category','link','image link','condition');
			
			$arr = array(
                $sku,
                $name . ' YOGA - YOGASMOGA',
                strip_tags($description),
                '',
                $buy_url,
                $image_url,
                'New',
                $available,      // In Stock / Out of stock
                $price,            // to-do
                '',
                '',
                'YOGASMOGA',
                '',
                $gender,       // to-do
                $age_group,    // to-do
                $size          // to-do
            );
			fputcsv($output, $arr);
        }
    }
}
fclose($fp);
?>
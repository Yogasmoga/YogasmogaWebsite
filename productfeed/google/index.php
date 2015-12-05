<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 3000);

require '../../app/Mage.php';
Mage::app();

/***************** get all colors from database ***********************/
$allColors = array();
$allColorAttribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'color'); //here, "color" is the attribute_code
$allColorOptions = $allColorAttribute->getSource()->getAllOptions(true, true);
foreach ($allColorOptions as $instance) {
    if (!array_key_exists($instance['value'], $allColors)) {
        $allColors[$instance['value']] = $instance['label'];
    }
}
/***************** get all colors from database end ***********************/

$fileIn = fopen("products.csv", "r");



header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=google_feed.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array(
    'Id',
    'Title',
    'Description',
    'google product category',
    'Product Type',
    'Link',
    'Image link',
    'Condition',
    'Availability',
    'Price',
    'Sale_price',
    'Sale_price_effective_date',
    'Brand',
    'Color',
    'Gender',
    'Age group',
    'Size',
    'promotion_id'
));

$arWomenCategory = array(3,6,7,8,16,71,43,59,65);
$arMenCategory = array(5,10,11,12,19);
$count = 0;

while (!feof($fileIn)) {

    $ar = fgetcsv($fileIn);
    if (++$count == 1)
        continue;

    $sku = $ar[0];
    $name = $ar[1];
	

	//$pos = strrpos($name, '-');
	//$name = substr($name, 0, $pos);
    //$size = substr($pos+1);
	$size = "";
	
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
			
			
			$_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $configurableProduct);
			$ar_child_sizes = array();
			foreach ($_childProducts as $_childProduct) {
				$size = $_childProduct->getAttributeText('size');

				if (is_numeric($size) && intval($size) > 12)
					continue;

				if (strpos(strtoupper($size), "T") !== false)
					continue;

				if (is_numeric($size))
					$ar_child_sizes[] = intval($size);
				else
					$ar_child_sizes[] = $size;
			}

			$ar_child_sizes = array_unique($ar_child_sizes);
			
			
			
            $categoryIds = $product->getCategoryIds();

            if (isset($categoryIds) && is_array($categoryIds) && count($categoryIds) > 0) {
                foreach ($categoryIds as $id) {
                    if (in_array(intval($id),$arWomenCategory))
                        $gender = "female";
                    else if (in_array(intval($id),$arMenCategory))
                        $gender = "male";
                }
            } else
                continue;

            unset($categoryIds);

            $buy_url = $configurableProduct->getUrlInStore();
            $keywords = $configurableProduct->getMetaKeyword();
            $price = round($configurableProduct->getPrice(),2);

            $images = Mage::getModel('catalog/product')->load($configurableProduct->getId())->getMediaGalleryImages();

			$productColors = array();
            if (isset($images) && count($images) > 0) {
				$first = true;
                foreach ($images as $image) {
					$imgdata = json_decode(trim($image->getLabel()), true);
					if (isset($imgdata['type']) && $imgdata['type'] == 'product image') {
						
						if($first){
							$first = !$first;
							$image_url = (string)Mage::helper('catalog/image')->init($configurableProduct, 'thumbnail', $image->getFile())->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(225, 364)->setQuality(91);
						}
						
						$productColors[] = $imgdata['color'];
					}
                }
            }
			
			$productColors = array_unique($productColors, SORT_REGULAR);
			
			$productColorsIndexed = array();
			foreach($productColors as $color)
				$productColorsIndexed[] = $color;

			$age_group = "Adult";
			
			foreach($productColorsIndexed as $colorCode){

				$total_name = $name . "-" . $allColors[$colorCode];
				$total_buy_url = $buy_url . "?color=" . $colorCode;
			
				$arr = array(
					$sku,
					'YOGASMOGA ' . $total_name . ' YOGA',
					'YOGASMOGA ' . strip_tags($description),
					'Apparel & Accessories > Clothing > Activewear',
                    '',
					$total_buy_url,
					$image_url,
					'New',
					$available,      // In Stock / Out of stock
					$price,            // to-do
					'',
					'',
					'YOGASMOGA',
					'Black',
					$gender,       // to-do
					$age_group,    // to-do
					implode(',',$ar_child_sizes),          // to-do
                    ''
				);

				fputcsv($output, $arr);
			}			
        }
    }
}
fclose($fp);
?>
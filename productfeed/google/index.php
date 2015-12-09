<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 3000);

require '../../app/Mage.php';
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




/***************** get all colors from database end ***********************/

$arWomenCategory = array(3,6,7,8,16,71,43,59,65);
$arMenCategory = array(5,10,11,12,19);
$count = 0;
$_helper = Mage::helper('catalog/output');
foreach($productCollection as $_product)
{
	
    $description = $_helper->productAttribute($_product,$_product->getDescription(),'description');
	
	
	
    //$description = trim(preg_replace('/\s+/', ' ', $description));

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
/*			
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
*/			
			
			
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

			foreach ($_childProducts as $_childProduct) {
			
				$buy_url = $configurableProduct->getUrlInStore();
				$keywords = $configurableProduct->getMetaKeyword();
				$price = round($configurableProduct->getPrice(),2);
				$sku = $_childProduct->getSku();
				$description = $_helper->productAttribute($configurableProduct,$configurableProduct->getDescription(),'description');

				$size = $_childProduct->getAttributeText('size');
				
				$color = $_childProduct->getAttributeText('color');
				$color = substr($color, 0, strpos($color, "|"));
                $colorCode = $allColorsNames[$childColorName];
				
				$productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_childProduct);
				$stock = $productStock->getQty();
                $inStock = $productStock->getIsInStock();
				if($stock<=0 || !$inStock)
					$available = 'out of stock';
				else
					$available = 'in stock';
				
				
				
				$_gallery = Mage::getModel('catalog/product')->load($configurableProduct->getId())->getMediaGalleryImages();
				
				
				
				 if (isset($_gallery)) {

					foreach ($_gallery as $_image) {
						$imageLabelData = json_decode(trim($_image->getLabel()), true);

						if ($imageLabelData == NULL || strcasecmp($imageLabelData['type'], "product image") != 0)
							continue;

						$colorCode = $imageLabelData['color'];

						if($colorCode !=  $colorCode)
							continue;
							$image_url = (string)Mage::helper('catalog/image')->init($configurableProduct, 'thumbnail', $_image)->constrainOnly(TRUE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(225, 364)->setQuality(91);
							break;
						}
				}
				
			
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				$age_group = "Adult";
			
				$total_name = $_childProduct->getName();
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
					$color,
					$gender,       // to-do
					$age_group,    // to-do
					$size,          // to-do
                    ''
				);

				fputcsv($output, $arr);
				}
			}			
        }
    }


?>
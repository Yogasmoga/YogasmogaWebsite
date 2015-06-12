<?php
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

    require '../app/Mage.php';
    Mage::app();

    $fileIn = fopen("products.csv","r");
    $fileOut = fopen("result.txt","w");

    fwrite($fileOut, "&CID=4521127\n");
    fwrite($fileOut, "&SUBID=171706\n");
    fwrite($fileOut, "&PROCESSTYPE=UPDATE\n");
    fwrite($fileOut, "&AID=12186878\n");
    fwrite($fileOut, "&PARAMETERS=NAME|KEYWORDS|DESCRIPTION|SKU|BUYURL|AVAILABLE|IMAGEURL|PRICE|UPC|ADVERTISERCATEGORY|MERCHANDISETYPE\n");

    $count = 0;

    while(! feof($fileIn))
    {

        $ar = fgetcsv($fileIn);
        if(++$count==1)
            continue;

        $sku = $ar[0];
        $name = $ar[1];
        $price = $ar[2];
        $description = trim($ar[3]);
        $available = $ar[4]==="1" ? 'YES':'NO';
        $keyword = '';
        $buy_url = '';
        $image_url = '';
        $advertise_category = 'yoga apparel';
        $merchandiseType = '';

        $description = trim(preg_replace('/\s+/', ' ', $description));

        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);

        if(!isset($product) || !is_object($product) || !$product->getId()) {
			echo "Bad product = $name ( $sku ) <br/>";
		}
		else{

            $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')
                ->getParentIdsByChild($product->getId());

            if (!isset($parentIds) || count($parentIds) == 0)
                continue;

            //$configurableProduct = Mage::getModel('catalog/product')->load($parentIds[0]);

            $categoryIds = Mage::getResourceModel('catalog/product')->getCategoryIds($product);
            if(isset($categoryIds) && is_array($categoryIds) && count($categoryIds)>0){
                foreach($categoryIds as $id){
                    if($id==43 || $id==8 || $id==12) {
                        $merchandiseType = "Non-commissionable Items";
                        break;
                    }
                }
            }

            $buy_url = $configurableProduct->getUrlInStore();
            $keywords = $configurableProduct->getMetaKeyword();

            $images = Mage::getModel('catalog/product')->load($configurableProduct->getId())->getMediaGalleryImages();

            if (isset($images) && count($images) > 0) {
                foreach ($images as $image) {
                    //$image_url = Mage::helper('catalog/image')->init($configurableProduct, 'small_image', $image->getFile())->resize(400,400);
                    $image_url = Mage::getModel('catalog/product_media_config')->getMediaUrl($configurableProduct->getImage());
                    break;
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
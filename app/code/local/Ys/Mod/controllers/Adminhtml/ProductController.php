<?php
class Ys_Mod_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    public function uploadProductsAction(){
        $this->loadLayout();
        $this->_title($this->__("Upload Products"));
        $this->renderLayout();
    }

/********************* product upload code **********************/

    public function saveProductsAction(){
echo "hi";
        die();
        $uploader = new Varien_File_Uploader('file');
        $uploader->setAllowedExtensions(array('json'));
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);
        $path = Mage::getBaseDir('media');
        $filename = $_FILES['file']['name'];
        $uploader->save($path, $filename);

        if(isset($_FILES["file"])) {
            $target_dir = getcwd();
            $target_file = $target_dir . basename($_FILES["file"]["name"]);

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $filename = $_FILES["file"]["name"];
                echo "done";
            }
        }
        else{
            echo "No file provided";
            die();
        }

        $filename = $path . $filename;

        $configurable_products      = $this->readConfigurable($filename);
        $product_colors             = $this->readProductColors($filename);
        $product_colors_to_add      = $this->readColorsToAdd($filename);
        $product_images             = $this->readProductImages($filename);
        $product_image_captions     = $this->readImageCaptions($filename);
        $assoc_products             = $this->readAssociatedProducts($filename);

        $this->createConfigurableProducts(
            $configurable_products,
            $product_colors,
            $product_colors_to_add,
            $product_images,
            $product_image_captions,
            $assoc_products
        );

        echo "done";
    }

    function readConfigurable($filename){
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $x = 0;

        $worksheet = $objPHPExcel->setActiveSheetIndex(2);

        $highestRow = $worksheet->getHighestRow(); // e.g. 10

        for ($row = 1; $row <= $highestRow; ++$row) {

            if($row>1) {            // $row = 0  is for heading
                $product_name       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $sku                = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

//        $_productId = Mage::getModel('catalog/product')->getIdBySku($sku);
//        $_product = Mage::getModel('catalog/product')->load($_productId);

//        if(!empty($_product))
//            continue;

                $primary_color      = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $short_description  = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $long_description   = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $how_does_it_fit    = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $size_chart         = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $product_order      = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $selling_price      = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                $reward_points      = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                $tax                = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                $url_key            = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                $tcategories        = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                $related_products   = $worksheet->getCellByColumnAndRow(13, $row)->getValue();

                if(strpos($tcategories,","))
                    $categories = explode(",", $tcategories);
                else {
                    $categories = array();
                    $categories[] = $tcategories;
                }

                $product = array(
                    "product_name"      => $product_name,
                    "sku"               => $sku,
                    "primary_color"     => $primary_color,
                    "short_description" => $short_description,
                    "long_description"  => $long_description,
                    "how_does_it_fit"   => $how_does_it_fit,
                    "size_chart"        => $size_chart,
                    "product_order"     => $product_order,
                    "selling_price"     => $selling_price,
                    "reward_points"     => $reward_points,
                    "tax"               => $tax,
                    "url_key"           => $url_key,
                    "categories"        => $categories,
                    "related_products"  => $related_products
                );

                $configurable_products[] = $product;
            }
        }

        unset($worksheet);

        return $configurable_products;
    }

    function readProductColors($filename){
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $worksheetColors = $objPHPExcel->setActiveSheetIndex(0);

        $highestRow = $worksheetColors->getHighestRow(); // e.g. 10

        for ($row = 1; $row <= $highestRow; ++$row) {

            if($row>1) {            // $row = 0  is for heading
                $color      = $worksheetColors->getCellByColumnAndRow(0, $row)->getValue();
                $position   = $worksheetColors->getCellByColumnAndRow(1, $row)->getValue();

                $color_row = array(
                    "color"     => $color,
                    "position"  => $position
                );

                $product_colors[] = $color_row;
            }
        }

        unset($worksheetColors);

        return $product_colors;
    }

    function readColorsToAdd($filename){
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $worksheetColors = $objPHPExcel->setActiveSheetIndex(1);

        $highestRow = $worksheetColors->getHighestRow(); // e.g. 10

        for ($row = 1; $row <= $highestRow; ++$row) {

            if($row>1) {            // $row = 0  is for heading
                $color      = $worksheetColors->getCellByColumnAndRow(0, $row)->getValue();
                $hex        = $worksheetColors->getCellByColumnAndRow(1, $row)->getValue();
                $position   = $worksheetColors->getCellByColumnAndRow(2, $row)->getValue();

                $color_row = array(
                    "color"     => $color,
                    "hex"       => $hex,
                    "position"  => $position
                );

                $produt_colors_to_add[] = $color_row;
            }
        }

        unset($worksheetColors);

        return $produt_colors_to_add;
    }

    function readProductImages($filename){
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $worksheetImages = $objPHPExcel->setActiveSheetIndex(3);

        $highestRow = $worksheetImages->getHighestRow(); // e.g. 10

        for ($row = 1; $row <= $highestRow; ++$row) {

            if($row>1) {            // $row = 0  is for heading
                $product_name   = $worksheetImages->getCellByColumnAndRow(0, $row)->getValue();
                $color          = $worksheetImages->getCellByColumnAndRow(1, $row)->getValue();
                $image_1        = $worksheetImages->getCellByColumnAndRow(2, $row)->getValue();
                $image_2        = $worksheetImages->getCellByColumnAndRow(3, $row)->getValue();
                $image_3        = $worksheetImages->getCellByColumnAndRow(4, $row)->getValue();
                $image_4        = $worksheetImages->getCellByColumnAndRow(5, $row)->getValue();
                $alt            = $worksheetImages->getCellByColumnAndRow(6, $row)->getValue();

                $image = array(
                    "product_name"  => $product_name,
                    "color"         => $color,
                    "image_1"       => $image_1,
                    "image_2"       => $image_2,
                    "image_3"       => $image_3,
                    "image_4"       => $image_4,
                    "alt"           => $alt
                );

                $product_images[] = $image;
            }
        }

        unset($worksheetImages);

        return $product_images;
    }

    function readImageCaptions($filename){
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $worksheetCaptions = $objPHPExcel->setActiveSheetIndex(4);

        $highestRow = $worksheetCaptions->getHighestRow(); // e.g. 10
        $highestColumn = $worksheetCaptions->getHighestColumn(); // e.g 'F'
        $nrColumns = ord($highestColumn) - 64;

        for ($row = 1; $row <= $highestRow; ++$row) {

            $product_name   = $worksheetCaptions->getCellByColumnAndRow(0, $row)->getValue();
            ++$row;     // Image1, Image2 heading
            ++$row;     // now read explanations

            $descriptions = array("product_name" => $product_name);

            $product_image_names = array();
            $product_image_captions = array();

            for($i = 0; $i < $nrColumns; $i++)
                $product_image_names[] = $worksheetCaptions->getCellByColumnAndRow($i, $row)->getValue();

            ++$row;     // now read captions

            for($i = 0; $i < $nrColumns; $i++)
                $product_image_captions[] = $worksheetCaptions->getCellByColumnAndRow($i, $row)->getValue();

            $caption = array(
                "product_name"  => $product_name,
                "product_image_names" => $product_image_names,
                "product_image_captions"  => $product_image_captions
            );

            ++$row;     // there is an empty line

            unset($ar);
            unset($descriptions);

            $product_captions[] = $caption;
        }

        unset($worksheetCaptions);

        return $product_captions;
    }

    function readAssociatedProducts($filename){
        require_once 'PHPExcel/IOFactory.php';

        $objPHPExcel = PHPExcel_IOFactory::load($filename);

        $worksheetAssociated = $objPHPExcel->setActiveSheetIndex(5);

        $highestRow = $worksheetAssociated->getHighestRow(); // e.g. 10

        for ($row = 1; $row <= $highestRow; ++$row) {

            if($row>1) {            // $row = 0  is for heading
                $sku            = $worksheetAssociated->getCellByColumnAndRow(0, $row)->getValue();
                $color          = $worksheetAssociated->getCellByColumnAndRow(1, $row)->getValue();
                $size           = $worksheetAssociated->getCellByColumnAndRow(2, $row)->getValue();
                $quantity       = $worksheetAssociated->getCellByColumnAndRow(3, $row)->getValue();    // quantity / inventory
                $weight_lbs     = $worksheetAssociated->getCellByColumnAndRow(4, $row)->getValue();
                $weight_ounces  = $worksheetAssociated->getCellByColumnAndRow(5, $row)->getValue();
                $pre_order      = $worksheetAssociated->getCellByColumnAndRow(6, $row)->getValue();
                $length         = $worksheetAssociated->getCellByColumnAndRow(7, $row)->getValue();

                $assoc_row = array(
                    "sku"           => $sku,
                    "color"         => $color,
                    "size"          => $size,
                    "quantity"      => $quantity,
                    "weight_lbs"    => $weight_lbs,
                    "weight_ounces" => $weight_ounces,
                    "pre_order"     => $pre_order,
                    "length"        => $length
                );

                $assoc_products[] = $assoc_row;
            }
        }

        unset($worksheetAssociated);

        return $assoc_products;
    }

    function createConfigurableProducts(
        $configurable_products,
        $product_colors,
        $product_colors_to_add,
        $product_images,
        $product_image_captions,
        $assoc_products)
    {
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        function getOptionId($attribute_code, $label)
        {
            $optionId = null;

            $attribute_model = Mage::getModel('eav/entity_attribute');
            $attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');
            $attribute_code = $attribute_model->getIdByCode('catalog_product', $attribute_code);
            $attribute = $attribute_model->load($attribute_code);
            $attribute_table = $attribute_options_model->setAttribute($attribute);
            $options = $attribute_options_model->getAllOptions(false);

            foreach ($options as $option) {
                if ($option['label'] == $label) {
                    $optionId = $option['value'];
                    break;
                }
            }

            return $optionId;
        }

        function getConfigurable($configurable_products, $sku_to_look){

            foreach ($configurable_products as $conf_product) {

                $single_sku = $conf_product['sku'];

                if($single_sku===$sku_to_look){
                    return $conf_product;
                }
            }
        }

        $simpleProducts = array();
        foreach ($assoc_products as $product) {

            $sProduct = Mage::getModel('catalog/product');

            $sku = $product['sku'] . "-" . $product['size'];

            $sProduct->setSku($sku);
            $sProduct->setWeight($product['weight_lbs']);
            $sProduct->setColor($product['color']);
            //$sProduct->setUrlKey($product['url_key']);
            $sProduct->setStockData(array(
                'is_in_stock' => 1,
                'qty' => $product['quantity']
            ));
            $sProduct->setAttributeSetId(4);        // default => 4

            $sProduct->setTypeId(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)
                ->setWebsiteIds(array(1))
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setTaxClassId(0);

            $optionId = getOptionId('size',$product['size']);
            $sProduct->setData('size',$optionId);

            $optionId = getOptionId('color',$product['color']);
            $sProduct->setData('color',$optionId);

            $optionId = getOptionId('length',1);
            $sProduct->setData('length',$optionId);

            $single_sku_value = substr($product['sku'], 0, strpos($product['sku'], "."));       // extract the word just before the first .
            $conf_product = getConfigurable($configurable_products, $single_sku_value);

            $product_name = $conf_product['product_name'] . "-" . $product['color'] . "-" . $product['size'];
            $sProduct->setName($product_name);
            $sProduct->setPrice($conf_product['selling_price']);
            $sProduct->setAttributeSetId(4);

            $sProduct->setCategoryIds($conf_product['categories']);
            $sProduct->setDescription('');
            $sProduct->setShortDescription('');

            $sProduct->save();

            // we are creating an array with some information which will be used to bind the simple products with the configurable
            $ar = array(
                "id" => $sProduct->getId(),
                "pricing_value" => $sProduct->getPrice(),
                "is_percent" => 0,
                "attr_code" => 'size',
                "attr_id" => 180,  // this is the attribute_id of 'size'
                "value" => $optionId,
                "label" => $product['size'],
                "sku" => $product['sku']
            );

            array_push( $simpleProducts, $ar );
        }

        foreach ($configurable_products as $conf_product) {

            $product = Mage::getModel('catalog/product');

            echo "<br/>Adding " . $conf_product['product_name'];

            $sku = $conf_product['sku'];

            $taxClassName = $conf_product['tax'];

            if(strtolower($taxClassName)=="massachusetts")
                $taxClassId = 6;
            else if(strtolower($taxClassName)=="below110")
                $taxClassId = 7;
            else if(strtolower($taxClassName)=="shipping")
                $taxClassId = 4;
            else if(strtolower($taxClassName)=="taxable goods")
                $taxClassId = 2;
            else
                $taxClassId = 0;

            $product->setWebsiteIds(array(1))
                ->setAttributeSetId(4)// 4 is the id of default attribute set
                ->setCreatedAt(strtotime('now'))
                ->setName($conf_product['product_name'])
                ->setDescription($conf_product['long_description'])
                ->setShortDescription($conf_product['short_description'])
                ->setSku($conf_product['sku'])
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTypeId(Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setTaxClassId($taxClassId)
                ->setUrlKey($conf_product['url_key'])
                ->setRewardPoints($conf_product['reward_points'])
                ->setCategoryIds($conf_product['categories'])
                ->setPrice($conf_product['selling_price']);

            echo "<br/>Default values set";

            $product->setStockData(
                array(
                    'is_in_stock' => 1,
                    'qty' => 99999
                )
            );

            echo "<br/>Stock set <br/>";

            // $product->save();
            // Store some data for later once we've created the configurable product, so we can
            // associate this simple product to it later..



            /*********************************************************************/
//    foreach($configAttrCodes as $attrCode){
//
//        $super_attribute= Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product',$attrCode->code);
//        $configurableAtt = Mage::getModel('catalog/product_type_configurable_attribute')->setProductAttribute($super_attribute);
//
//        $newAttributes[] = array(
//            'id'             => $configurableAtt->getId(),
//            'label'          => $configurableAtt->getLabel(),
//            'position'       => $super_attribute->getPosition(),
//            'values'         => $configurableAtt->getPrices() ? $configProduct->getPrices() : array(),
//            'attribute_id'   => $super_attribute->getId(),
//            'attribute_code' => $super_attribute->getAttributeCode(),
//            'frontend_label' => $super_attribute->getFrontend()->getLabel(),
//        );
//    }
//
//    $existingAtt = $product->getTypeInstance()->getConfigurableAttributes();
//
//    if(empty($existingAtt) && !empty($newAttributes)){
//        $configProduct->setCanSaveConfigurableAttributes(true);
//        $configProduct->setConfigurableAttributesData($newAttributes);
//        $configProduct->save();
//
//    }
            /*********************************************************************/





            /************************ set attributes for this configurable product ************************/

            $product->setCanSaveConfigurableAttributes(true);
            $product->setCanSaveCustomOptions(true);

            $cProductTypeInstance = $product->getTypeInstance();

            /************ problem creating lines *************/
            if(strlen(trim($product['length']))>0)
                $attribute_ids = array(92,138,172);     // ids of color,size,length
            else
                $attribute_ids = array(92,138);     // ids of color,length,size

            $cProductTypeInstance->setUsedProductAttributeIds($attribute_ids);

            $attributes_array = $cProductTypeInstance->getConfigurableAttributesAsArray();
            /************ problem creating lines *************/

            foreach ($attributes_array as $key => $attribute_array) {
                $attributes_array[$key]['use_default'] = 1;
                $attributes_array[$key]['position'] = 0;

                if (isset($attribute_array['frontend_label'])) {
                    $attributes_array[$key]['label'] = $attribute_array['frontend_label'];
                } else {
                    $attributes_array[$key]['label'] = $attribute_array['attribute_code'];
                }
            }

            $product->setConfigurableAttributesData($attributes_array);

            /************************ set attributes for this configurable product ************************/

            /************************ connect simple products to this configurable product ************************/

            $dataArray = array();
            foreach ($simpleProducts as $simpleArray) {

                $single_sku = $simpleArray['sku'];

                $single_sku_value = substr($single_sku, 0, strpos($single_sku, "."));       // extract the word just before the first .

                if($sku===$single_sku_value) {

                    $dataArray[$simpleArray['id']] = array();

                    foreach ($attributes_array as $key => $attrArray) {
                        array_push(
                            $dataArray[$simpleArray['id']],
                            array(
                                "attribute_id" => $simpleArray['attr_id'][$key],
                                "label" => $simpleArray['label'][$key],
                                "is_percent" => false,
                                "pricing_value" => $simpleArray['pricing_value'][$key]
                            )
                        );
                    }
                }
            }
            $product->setConfigurableProductsData($dataArray);

            echo "<br/>Data array set";

            $product->save();

            /************************ connect simple products to this configurable product ************************/

            unset($dataArray);

            echo "<br/>Saved <hr/>";
        }

        echo "Task completed";
    }
}
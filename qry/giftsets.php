<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

$storeId = Mage::app()->getStore()->getStoreId();
$catId = Mage::getModel('catalog/layer')->getCurrentCategory()->getId();
$_helper = Mage::helper('catalog/output');

$productCollection = Mage::getModel('catalog/category')->load($catId)
    ->getProductCollection()
    ->addAttributeToSelect('*');

$cities = array();
$latlongs = array();
$cityTimes = array();

$resourceModel = Mage::getResourceModel('catalog/product');

/***************** get all colors from database ***********************/
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
/***************** get all sizes from database ***********************/
$allSizes = array();
$allSizeAttribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'size'); //here, "color" is the attribute_code
$allSizeOptions = $allSizeAttribute->getSource()->getAllOptions(true, true);
foreach ($allSizeOptions as $instance) {
    if ($instance['label'] != "") {
        if (is_numeric($instance['label']) && intval($instance['label']) > 12)
            continue;

        if (strpos(strtoupper($instance['label']), "T") !== false)
            continue;

        $allSizes[$instance['label']] = $instance['value'];
    }
}

foreach ($productCollection as $_product_single) {
    $_product = Mage::getModel('catalog/product')->load($_product_single->getId());

    echo "<b>Gift Set : " . $_product->getName() . "</b> , ";

    // check if gift set simple product is out of stock
    $_childProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_product_single);
    $outOfStock = false;
    foreach ($_childProducts as $simple) {

        $productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($simple);

        $stock = $productStock->getQty();
        $inStock = $productStock->getIsInStock();

        if ($stock <= 0 || !$inStock) {
            $outOfStock = true;
            $outOfStockSets[] = $_product_single->getId();
        }

        break;
    }

    echo $outOfStock ? "Out of stock" : "In stock <br/>";

    /******************************  check if any of the gift set bundled products are out of stock *************************/
    $bundled_product_ids = $resourceModel->getAttributeRawValue($_product->getId(), 'bundle_products', $storeId);

    if (isset($bundled_product_ids))
        $bundled_product_ids = trim($bundled_product_ids);

    $ar_bundled_product_ids = explode(",", $bundled_product_ids);

    $anyBundledOutOfStock = false;
    for ($i = 0; $i < count($ar_bundled_product_ids); $i++) {

        $ar_id_color_code = explode(":", $ar_bundled_product_ids[$i]);          // id:color_code

        $bundle_configurable_id = $ar_id_color_code[0];
        $bundle_color_id = $ar_id_color_code[1];

        $_bundle_product = Mage::getModel('catalog/product')->load(intval($bundle_configurable_id));

        /************** check if all simple products are out of stock or not ********************/
        $_bundleChildProducts = Mage::getModel('catalog/product_type_configurable')->getUsedProducts(null, $_bundle_product);
        foreach ($_bundleChildProducts as $_bundleChildProduct) {

            /************ get color code of simple product and match it with passed color code **************/
            $bundleChildName = $_bundleChildProduct->getName();
            $bundleChildColor = $_bundleChildProduct->getAttributeText('color');
            $bundleChildColorName = substr($bundleChildColor, 0, strpos($bundleChildColor, "|"));
            $bundleChildColorCode = $allColorsNames[$bundleChildColorName];

            if ($bundleChildColorCode == $bundle_color_id) {

                $productStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_bundleChildProduct);

                $stock = $productStock->getQty();
                $inStock = $productStock->getIsInStock();

                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                if ($stock > 0 && $inStock)
                    echo $_bundleChildProduct->getName() . " : In stock";
                else
                    echo $_bundleChildProduct->getName() . " : Out of stock";
            }
        }
    }

    echo "<hr/>";
}
?>
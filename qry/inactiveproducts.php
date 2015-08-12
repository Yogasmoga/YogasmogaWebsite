<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=products.csv');
$output = fopen('php://output', 'w');
$products = Mage::getModel('catalog/product')
    ->getCollection()
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('type_id', array('eq' => 'simple'));

fputcsv($output, array('Sku', 'Name', 'Quantity'));
foreach ($products as $product) {
    $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($product->getId());
    if ($parentIds[0] == null) {
        $stock = Mage::getModel('cataloginventory/stock_item')->load($product->getId());
        $rows = array(
            'Sku' => $product->getSku(),
            'Name' => $product->getName(),
            'Quantity' => $stock->getQty()
        );
        fputcsv($output, $rows);
    }
}
?>
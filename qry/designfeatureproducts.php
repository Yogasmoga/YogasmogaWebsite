<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=design_products.csv');
$output = fopen('php://output', 'w');
$products = Mage::getModel('catalog/product')
    ->getCollection()
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('type_id', array('eq' => 'configurable'));

fputcsv($output, array('Sku', 'Name', 'Label'));
foreach ($products as $_product) {
    $product = Mage::getModel('catalog/product')->load($_product->getId());
    $_gallery = $product->getMediaGalleryImages();

    if(isset($_gallery) && count($_gallery)>0) {

        foreach ($_gallery as $_image) {

            $imageLabelData = json_decode(trim($_image->getLabel()), true);

            if ($imageLabelData != NULL && strcasecmp($imageLabelData['type'], "new design feature image") == 0) {
                fputcsv($output, array($product->getSku(), $product->getName(), $_image->getLabel()));
            }
        }
    }
}
?>
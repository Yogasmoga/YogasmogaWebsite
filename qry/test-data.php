<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

$source_box = 1;

$source = $_REQUEST['source'];

if(isset($source))
    if($source==1 || $source==2)
        $source_box = $_REQUEST['source'];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=design_products.csv');
$output = fopen('php://output', 'w');

fputcsv($output, array('Email', 'Name'));

$read = Mage::getSingleton('core/resource')->getConnection('core_read');

$sql = "SELECT email,first_name,last_name FROM test_customers WHERE source_box='$source_box'";

$results=$read->fetchAll($sql);

foreach($results as $result){
    fputcsv($output, array($result[0], $result[1] . ' ' . $result[1]));
}
?>
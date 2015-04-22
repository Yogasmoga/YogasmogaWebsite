<?php
require 'app/Mage.php';

Mage::app();

$fromDate = date('Y-m-d', strtotime('2014-11-15'));
$toDate = date('Y-m-d');

$collection = Mage::getModel('customer/customer')->getCollection();

$cnt = 0;

foreach ($collection as $user) {
//    $orders = Mage::getModel('sales/order')
//        ->getCollection()
//        ->addAttributeToFilter('created_at', array('from' => $fromDate, 'to' => $toDate))
//        ->addFieldToSelect('increment_id')
//        ->addFieldToFilter('customer_id', $user->getId());

    $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToSelect('increment_id')
        ->addFieldToFilter('customer_id', $user->getId());

    if ($orders->getSize() == 0) {
        ++$cnt;
        echo $user->getEmail() . "<br/>";
    }
}
?>

<hr/>
<h3>Total customers who have not ordered between <?php echo $fromDate;?> to <?php echo $toDate;?> = <?php echo $cnt; ?></h3>
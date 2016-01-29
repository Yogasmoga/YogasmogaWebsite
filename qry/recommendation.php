<?php

require_once '../app/Mage.php';
Mage::app();
umask(0);

$currentDate = date('Y-m-d');
$fromDate = date('Y-m-d 00:00:01', strtotime('-50 days', strtotime($currentDate)));
$toDate = date('Y-m-d 23:59:59', strtotime('-50 days', strtotime($currentDate)));

echo "Range = [$fromDate , $toDate]<br/><br/>";

$orders = Mage::getModel('sales/order')->getCollection()
    ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
    ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE));

if(isset($orders)) {
    echo "Orders found = " . count($orders) . "<br/><br/>";
    foreach ($orders as $order) {
        echo "Order Id = " . $order->getIncrementId() . "<br/>";
        echo "Customer Id = " . $order->getCustomerId() . "<br/><br/>";

        $orderedItems = $order->getAllVisibleItems();
        $orderedProductIds = [];

        foreach ($orderedItems as $item) {
            $orderedProductIds[] = $item->getData('product_id');
        }

        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addIdFilter($orderedProductIds);

        $products = $productCollection->load();

        if(isset($products)){
            echo "Products ordered = " . count($products) . "<br/><br/>";
            foreach($products as $product){
                echo "Product id = " . $product->getId() .' Product Name: '.$product->getName(). "<br/>";
            }
        }
        echo "<hr/>";
    }
}
else
    echo "No orders found";
?>



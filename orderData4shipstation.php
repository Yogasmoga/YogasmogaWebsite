<?php
/**
 * Created by PhpStorm.
 * User: Fahim Khan
 * Date: 24-11-2016
 * Time: 02:48 PM
 */

ini_set("memory_limit", "320M");
set_time_limit(0);


//12-02-2013
require_once 'app/Mage.php';
Mage::app();
umask(0);

$date_to_look_start = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
$date_to_look_end = date('Y-m-d', strtotime(date('Y-m-d')));


$orders = Mage::getModel('sales/order')
    ->getCollection()
    ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
    ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));

echo '<pre/>';
//print_r($orders->getData());




//foreach($orders as $order){


$orderId = '100021922';

//$orderId = '100014441';

    $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
    print_r($order->getData());
    echo "<hr/>";

    //echo "<pre/>";
    //print_r($orderData->getAllVisibleItems()->getData());
    $items= array();
    foreach($order->getAllVisibleItems() as $item){
        $items['name']=$item->getName();
        $items['sku']=$item->getSku();
        /*$options = $item->getProductOptions();

        foreach($item->getProductOptions() as $key => $options){
            $color = $options[0]['value'];
            if(isset($color)) {
                $color = substr($color, 0, strpos($color, "|"));
            }

        }
        $items[] = $color;*/
        $items['qty']=round($item->getQtyOrdered());
        $items['price']=round($item->getPrice());
    }
//}
echo '<pre/>';
print_r($items);

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

$date_to_look_start = date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))));
$date_to_look_end = date('Y-m-d', strtotime(date('Y-m-d')));


$orders = Mage::getModel('sales/order')
    ->getCollection()
    ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
    ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=orderdata4shipstation.csv');
$fp = fopen('php://output', 'w');

fputcsv($fp, array("order_id","created_at","grand_total","total_paid","tax_amount","shipping_amount","shipping_description","customer name","customer_firstname","customer_lastname","customer_email",
    "shipping_telephone","shipping_first_name","shipping_last_name","shipping_full_name","shipping_address","shipping_city","shipping_region","shipping_postcode","shipping_country",
    "billing_telephone","billing_first_name","billing_last_name","billing_full_name","billing_address","billing_city","billing_region","billing_postcode","billing_country",
    "product_name","sku","qty","price"));

$items =array();
foreach($orders as $order){
//$orderId = '100021922';
//if($order->getIncrementId()=='100021922') {

    $order = Mage::getModel('sales/order')->loadByIncrementId($order->getIncrementId());
    //print_r($order->getData());
    //echo "<hr/>";


    /****************--------------***********/
    $items[] = $order->getData('increment_id');
    $items[] = $order->getData('created_at');
    $items[] = $order->getData('grand_total');
    $items[] = $order->getData('total_paid');
    $items[] = $order->getData('tax_amount');
    $items[] = $order->getData('shipping_amount');
    $items[] =$order->getData('shipping_description');
    $items[] = $order->getData('customer_firstname') . ' ' . $order->getData('customer_lastname');
    $items[] = $order->getData('customer_firstname');
    $items[] = $order->getData('customer_lastname');
    $items[] = $order->getData('customer_email');

    //echo "Shipping Address.<br/>";

    $items[] = $order->getShippingAddress()->getTelephone();
    $items[] = $order->getShippingAddress()->getFirstname();
    $items[] = $order->getShippingAddress()->getLastname();
    $items[] = $order->getShippingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname();
    $items[] = $order->getShippingAddress()->getData('street');
    $items[] = $order->getShippingAddress()->getCity();
    $items[] = $order->getShippingAddress()->getRegion();
    $items[] = $order->getShippingAddress()->getPostcode();
    $items[] = $order->getShippingAddress()->getCountryId();

    //echo "Billing Address <br/>";
    $items[] = $order->getBillingAddress()->getTelephone();
    $items[] = $order->getBillingAddress()->getFirstname();
    $items[] = $order->getBillingAddress()->getLastname();
    $items[] = $order->getBillingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname();
    $items[] = $order->getBillingAddress()->getData('street');
    $items[] = $order->getBillingAddress()->getCity();
    $items[] = $order->getBillingAddress()->getRegion();
    $items[] = $order->getBillingAddress()->getPostcode();
    $items[] = $order->getBillingAddress()->getCountryId();

    foreach ($order->getAllVisibleItems() as $item) {

        $items[] = $item->getName();
        $items[] = $item->getSku();
        $items[] = $item->getQtyOrdered();
        $items[] = $item->getPrice();
    }
    fputcsv($fp,$items);
//}

}

fclose($fp);
exit;

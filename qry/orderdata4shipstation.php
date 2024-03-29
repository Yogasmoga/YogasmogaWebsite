<?php
/**
 * Created by PhpStorm.
 * User: Fahim Khan
 * Date: 24-11-2016
 * Time: 02:48 PM
 */


ini_set("memory_limit", "320M");
set_time_limit(0);
ini_set("error_reporting",E_ALL);
ini_set("display_errors",true);

//12-02-2013
require_once '../app/Mage.php';
Mage::app();
umask(0);

//echo $date_to_look_start = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))))."<br/>";
//echo $date_to_look_end = date('Y-m-d', strtotime(date('Y-m-d')));

$date_to_look_start = Mage::app()->getRequest()->getParam('startdate');
$date_to_look_end = Mage::app()->getRequest()->getParam('enddate');

$orders = Mage::getModel('sales/order')
    ->getCollection()
    ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
    ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=orderdata4shipstation.csv');
$fp = fopen('php://output', 'w');

fputcsv($fp, array("order_id","created_at","grand_total","total_paid","tax_amount","shipping_amount",
    "shipping_description","customer_name","customer_firstname","customer_lastname",
    "customer_email","shipping_telephone","shipping_first_name","shipping_last_name",
    "shipping_full_name","shipping_address","shipping_city","shipping_region","shipping_postcode",
    "shipping_country","billing_telephone","billing_first_name","billing_last_name","billing_full_name",
    "billing_address","billing_city","billing_region","billing_postcode","billing_country",
    "product_name","sku","qty","price"));


foreach($orders as $order) {
//$orderId = '100021922';
//if($order->getIncrementId()!='100020357') {

    $order = Mage::getModel('sales/order')->loadByIncrementId($order->getIncrementId());


    /****************--------------***********/


    //echo "Shipping Address.<br/>";

    //$stelephone = Mage::getModel('customer/customer')->load($order->getData('customer_id'))->getPrimaryBillingAddress()->getTelephone();
    if ($order->getShippingAddress()) {
        $stelephone = $order->getShippingAddress()->getTelephone();
        $sfirstname = $order->getShippingAddress()->getFirstname();
        $slastname = $order->getShippingAddress()->getLastname();
        $sfullname = $order->getShippingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname();
        $saddress = $order->getShippingAddress()->getData('street');
        $scity = $order->getShippingAddress()->getCity();
        $sregion = $order->getShippingAddress()->getRegion();
        $spostcode = $order->getShippingAddress()->getPostcode();
        $scountry = $order->getShippingAddress()->getCountryId();
    } else {

        $stelephone = '';
        $sfirstname = '';
        $slastname = '';
        $sfullname = '';
        $saddress = '';
        $scity = '';
        $sregion = '';
        $spostcode = '';
        $scountry = '';
    }

    //echo "Billing Address <br/>";

    if ($order->getBillingAddress()) {

        $btelephone = $order->getBillingAddress()->getTelephone();
        $bfirstname = $order->getBillingAddress()->getFirstname();
        $lastname = $order->getBillingAddress()->getLastname();
        $bfullname = $order->getBillingAddress()->getFirstname() . ' ' . $order->getBillingAddress()->getLastname();
        $bstreet = $order->getBillingAddress()->getData('street');
        $bcity = $order->getBillingAddress()->getCity();
        $bregion = $order->getBillingAddress()->getRegion();
        $bpostcode = $order->getBillingAddress()->getPostcode();
        $bcountry = $order->getBillingAddress()->getCountryId();

    } else {

        $btelephone = '';
        $bfirstname = '';
        $lastname = '';
        $bfullname = '';
        $bstreet = '';
        $bcity = '';
        $bregion = '';
        $bpostcode = '';
        $bcountry = '';

    }


    $i = 0;
    foreach ($order->getAllVisibleItems() as $item) {

        if ($i == 0) {
            $items = array(
                $order->getData('increment_id'),
                $order->getData('created_at'),
                $order->getData('grand_total'),
                $order->getData('total_paid'),
                $order->getData('tax_amount'),
                $order->getData('shipping_amount'),
                $order->getData('shipping_description'),
                $order->getData('customer_firstname') . ' ' . $order->getData('customer_lastname'),
                $order->getData('customer_firstname'),
                $order->getData('customer_lastname'),
                $order->getData('customer_email'),
                $stelephone,
                $sfirstname,
                $slastname,
                $sfullname,
                $saddress,
                $scity,
                $sregion,
                $spostcode,
                $scountry,
                $btelephone,
                $bfirstname,
                $lastname,
                $bfullname,
                $bstreet,
                $bcity,
                $bregion,
                $bpostcode,
                $bcountry,
                $item->getName(),
                $item->getSku(),
                $item->getQtyOrdered(),
                $item->getPrice()
            );
        } else {
            $items = array(
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                " ",
                $item->getName(),
                $item->getSku(),
                $item->getQtyOrdered(),
                $item->getPrice()
            );

        }

        $i++;
        fputcsv($fp, $items);

//}
    }
}
fclose($fp);
exit;

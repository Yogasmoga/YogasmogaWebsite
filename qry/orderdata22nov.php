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
$limit = Mage::app()->getRequest()->getParam('limit');
/* if(isset($limit)){
    $collection = Mage::getModel('sales/order')
        ->getCollection()
        ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
        ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));

    $orders = $collection->setPageSize($limit)->setCurPage(1);

}
else {*/
    $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
        ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));
//}

//$stelephone = Mage::getModel('customer/customer')->load(16130)->getPrimaryBillingAddress();
/*
echo "<pre/>";

print_r($orders->getData());

exit;
*/


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=orderdata4shipstation.csv');
$fp = fopen('php://output', 'w');
/*
fputcsv($fp, array("order_id","created_at","grand_total","total_paid","tax_amount","shipping_amount",
    "shipping_description","customer_name","customer_firstname","customer_lastname",
    "customer_email","shipping_telephone","shipping_first_name","shipping_last_name",
    "shipping_full_name","shipping_address","shipping_city","shipping_region","shipping_postcode",
    "shipping_country","billing_telephone","billing_first_name","billing_last_name","billing_full_name",
    "billing_address","billing_city","billing_region","billing_postcode","billing_country",
    "product_name","sku","qty","price"));

*/


fputcsv($fp, array("order_id","created_at","grand_total","total_paid","tax_amount","shipping_amount",
    "shipping_description","customer_name","customer_firstname","customer_lastname",
    "customer_email","product_name","sku","qty","price"));

foreach($orders as $order) {
//$orderId = '100021922';
//if($order->getIncrementId()=='100014439') {

    $order = Mage::getModel('sales/order')->loadByIncrementId($order->getIncrementId());



    /****************--------------***********/


    //echo "Shipping Address.<br/>";
    /*
     $customer = Mage::getModel('customer/customer')->load($order->getData('customer_id'));
    $shippingAddress = $customer->getPrimaryShippingAddress();

    $stelephone = $order->getShippingAddress()->getTelephone();
    $sfirstname = $order->getShippingAddress()->getFirstname();
    $slastname = $order->getShippingAddress()->getLastname();
    $sfullname = $order->getShippingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname();
    $saddress = $order->getShippingAddress()->getData('street');
    $scity = $order->getShippingAddress()->getCity();
    $sregion = $order->getShippingAddress()->getRegion();
    $spostcode = $order->getShippingAddress()->getPostcode();
    $scountry = $order->getShippingAddress()->getCountryId();
    */
    /*
        $stelephone = $shippingAddress->getTelephone();
        $sfirstname = $shippingAddress->getFirstname();
        $slastname = $shippingAddress->getLastname();
        $sfullname = $shippingAddress->getFirstname() . ' ' . $shippingAddress->getLastname();
        $saddress = $shippingAddress->getStreet();
        $scity = $shippingAddress->getCity();
        $sregion = $shippingAddress->getRegion();
        $spostcode = $shippingAddress->getPostcode();
        $scountry = $shippingAddress->getCcountryId();
    */


    //echo "Billing Address <br/>";
    //$billingAddress = Mage::getModel('customer/customer')->load($order->getData('customer_id'))->getPrimaryBillingAddress();
    /*
    $btelephone = $order->getBillingAddress()->getTelephone();
    $bfirstname = $order->getBillingAddress()->getFirstname();
    $blastname = $order->getBillingAddress()->getLastname();
    $bfullname = $order->getBillingAddress()->getFirstname() . ' ' . $order->getShippingAddress()->getLastname();
    $bstreet = $order->getBillingAddress()->getData('street');
    $bcity = $order->getBillingAddress()->getCity();
    $bregion = $order->getBillingAddress()->getRegion();
    $bpostcode = $order->getBillingAddress()->getPostcode();
    $bcountry = $order->getBillingAddress()->getCountryId();
    */
    /*
    $btelephone  = $billingAddress->getData('telephone');
    $bfirstname  =  $billingAddress->getData('firstname');
    $blastname   =  $billingAddress->getData('lastname');
    $bfullname   =  $billingAddress->getData('firstname').' '.$shippingAddress->getData('lastname');
    $baddress    =  $billingAddress->getData('street');
    $bcity       =  $billingAddress->getData('city');
    $bregion     =  $billingAddress->getData('region');
    $bpostcode   =  $billingAddress->getData('postcode');
    $bcountry    =  $billingAddress->getData('country_id');
    */


    $i=0;
    foreach ($order->getAllVisibleItems() as $item) {

        if($i==0){
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
                $item->getName(),
                $item->getSku(),
                $item->getQtyOrdered(),
                $item->getPrice()
            );

        }else{

            $items = array(
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                $item->getName(),
                $item->getSku(),
                $item->getQtyOrdered(),
                $item->getPrice()
            );

        }

        $i++;
        fputcsv($fp,$items);
    }


/*
    $arr1 =   array($order_id,$created_at,$grand_total,$total_paid,$tax_amount,
        $shipping_amount,$shipping_description,$name,$firstname,$lastname,$email,
        $stelephone,$sfirstname,$slastname,$sfullname,$saddress,$scity,$sregion,
        $spostcode,$scountry,$btelephone,$bfirstname,$blastname,$bfullname,$bstreet,
        $bcity,$bregion,$bpostcode,$bcountry);
  */



//}
}
//echo count($finalData)."<hr/>";
//echo "<pre/>";
//print_r($finalData);
fclose($fp);
exit;

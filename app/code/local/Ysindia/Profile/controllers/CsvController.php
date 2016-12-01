<?php
/**
 * Created by PhpStorm.
 * User: Fahim Khan
 * Date: 01-12-2016
 * Time: 11:43 AM
 */
class Ysindia_Profile_CsvController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
        $type = Mage::app()->getRequest()->getParam('type');
        $startDate = Mage::app()->getRequest()->getParam('startdate');
        $endDate = Mage::app()->getRequest()->getParam('enddate');

        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$type.address22nov.csv");
        $fp = fopen('php://output', 'w');
        fputcsv($fp, array("order_id","customer_firstname","customer_lastname",
            "customer_country","customer_region","customer_address","customer_city",
            "customer_telephone","customer_zipcode","order_date"
            ));


        $sql = "SELECT
      sfo.increment_id as order_id,
	  $type.firstname, $type.lastname,
	  $type.country_id,
	  $type.region,
	  $type.street,
	  $type.city,
	  $type.telephone,
	  $type.postcode,  sfo.created_at
	FROM sales_flat_order AS sfo
	JOIN sales_flat_order_address AS $type
    ON $type.parent_id = sfo.entity_id
    AND $type.address_type = '$type'
	WHERE (sfo.created_at BETWEEN '$startDate 00:00:01' AND  '$endDate 23:59:59')";

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $readresult=$read->query($sql);
        while($row = $readresult->fetch()){
            $items = array(
                $row['order_id'],
                $row['firstname'],
                $row['lastname'],
                $row['country_id'],
                $row['region'],
                $row['street'],
                $row['city'],
                $row['telephone'],
                $row['postcode'],
                $row['created_at']
                ) ;
            fputcsv($fp,$items);
        }
        fclose($fp);
        exit;


    }
}

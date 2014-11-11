<?php

$myfile = fopen("mailchimp_list.txt", "r") or die("Unable to open file!");
$api_key = trim(fgets($myfile));
$list_id = trim(fgets($myfile));
fclose($myfile);

if(isset($list_id) && strlen($list_id)>0){

ini_set('max_execution_time', 36000);
ini_set('memory_limit', '1024M');

echo "Synchronizing, please wait...";

require 'app/Mage.php';
$app = Mage::app('');


$array = array();

$collectionSub = Mage::getResourceModel ('newsletter/subscriber_collection')           
            -> AddFieldToFilter ('subscriber_status', array ('eq' => 3));						/* 1=> subscribed,  2=> not active,  3=> unsubscribed */
			

foreach($collectionSub as $sub) {
	$array[] = $sub['subscriber_email'];
}

$collection = Mage::getModel('customer/customer')->getCollection()
->addAttributeToSelect('firstname')
->addAttributeToSelect('lastname')
->addAttributeToSelect('email')
->addAttributeToFilter('email', array('nin' => $array));

foreach ($collection as $item)
{
	$row = $item->getData();
	$batch[] = array('EMAIL'=>$row['email'], 'FNAME'=>$row['firstname'], 'LNAME'=>$row['lastname']);
}

include("mailchimpapi/Drewm/MailChimp.php");

$mailChimp = new Drewm\MailChimp($api_key);

$i = 0;
foreach($batch as $single){

	++$i;
	
	$email = $single["EMAIL"];
	$fname = $single["FNAME"];
	$lname = $single["LNAME"];
	
    $result = $mailChimp->call('lists/subscribe', array(
        'id'                => $list_id,
        'email'             => array('email'=>$email),
        'merge_vars'        => array('FNAME'=>$fname, 'LNAME'=>$lname),
        'double_optin'      => false,
        'update_existing'   => true,
        'replace_interests' => false,
        'send_welcome'      => false,
    ));
	
	print_r($result);
	
	echo "<hr/>";
}

echo "<br/>Task completed";

}
else
	echo "I guess list id is not provided or invalid";
?>
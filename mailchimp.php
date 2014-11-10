<?php
$myfile = fopen("mailchimp.txt", "r") or die("Unable to open file!");
$api_key = fgets($myfile);
$list_id = fgets($myfile);
fclose($myfile);

echo "[ $api_key , $list_id ] <br/><br/>";

ini_set('max_execution_time', 36000);
ini_set('memory_limit', '1024M');

require 'app/Mage.php';
$app = Mage::app('');

$columns = array('customers_firstname','customers_lastname','customers_email_address');

/* get Newsletter Subscriber whose status is equal to "Subscribed"    */

$sql = "SELECT * FROM newsletter_subscriber WHERE subscriber_status = 1";
$connection = Mage::getSingleton('core/resource')->getConnection('core_read');

$i = 0;
foreach ($connection->fetchAll($sql) as $arr_row) {

	++$i;

    $loademail = $arr_row['subscriber_email'];

    $customer = Mage::getModel('customer/customer');
    $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
    $customer->loadByEmail($loademail);

    $fname = explode(',', $customer->getData('firstname'));
    $lname = explode(',', $customer->getData('lastname'));
    $email = explode(',', $customer->getData('email'));
    $fname = $fname[0];
    $lname = $lname[0];
    $email = $email[0];
    if ($fname=="" && $lname=="")
    {
        $fname="--";
        $lname="--";
        $email=$arr_row['subscriber_email'];
    }

    $batch[] = array('EMAIL'=>$email, 'FNAME'=>$fname, 'LNAME'=>$lname);
}

echo "Found = " . count($batch);

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
}
?>
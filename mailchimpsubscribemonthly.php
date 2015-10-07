<?php
require 'app/Mage.php';
$app = Mage::app('');
umask(0);

ini_set('max_execution_time', 60);

$myfile = fopen("mailchimp_list.txt", "r") or die("Unable to open file!");
$apikey_listid = trim(fgets($myfile));
fclose($myfile);

$ar = explode(",", $apikey_listid);

$api_key = trim($ar[0]);
$list_id = trim($ar[1]);

$correct = isset($api_key) && isset($list_id) && (strlen($list_id) > 0) && (strlen($api_key) > 0);

if ($correct) {

    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $date_to_start = '2015-07-01';
    $date_to_end = '2015-07-31';

    echo "Between " . $date_to_start . " and " . $date_to_end . "<br/><br/>";

    $collection = Mage::getModel('customer/customer')->getCollection()
        ->addAttributeToSelect('entity_id')
        ->addAttributeToSelect('firstname')
        ->addAttributeToSelect('lastname')
        ->addAttributeToSelect('email')
        ->addAttributeToFilter('created_at', array('gteq' => $date_to_start . ' 00:00:01'))
        ->addAttributeToFilter('created_at', array('lteq' => $date_to_end . ' 23:59:59'));

    if ($collection && count($collection) == 0) {
        echo "No records found";
        return;
    } else
        echo count($collection) . " records found<br/><br/>";

    $unsubscribeCount = 0;

    foreach ($collection as $item) {
        $row = $item->getData();

        $email = $row['email'];

        $query = "select email from unsubscribed_customers where email='$email'";
        $rows = $readConnection->fetchAll($query);

        if (isset($rows) && count($rows) > 0) {
            echo $rows[0][0] . " is unsubscribed<br/>";
            continue;
        }

        unset($rows);

        $customerId = $row['entity_id'];

        $customer = Mage::getModel('customer/customer')->load($customerId);

        $gender = $customer->getGender();

        $customerAddress = null;

        foreach ($customer->getAddresses() as $address) {
            $customerAddress = $address->toArray();
            break;
        }

        $country = "";
        $state = "";
        if ($customerAddress) {
            $country = Mage::app()->getLocale()->getCountryTranslation($customerAddress['country_id']);
            $state = $customerAddress['region'];
        }

        if (isset($gender) && strlen(trim($gender)) > 0) {
            if ($gender == "1")
                $gender = "MALE";
            else
                $gender = "FEMALE";
        } else
            $gender = '';

        $batch[] = array(
            'EMAIL' => $row['email'],
            'FNAME' => $row['firstname'],
            'LNAME' => $row['lastname'],
            'STATE' => $state,
            'COUNTRY' => $country,
            'GENDER' => $gender
        );
    }

    include("mailchimpapi/Drewm/MailChimp.php");

    $mailChimp = new Drewm\MailChimp($api_key);

    $i = 0;
    foreach ($batch as $single) {

        ++$i;

        $email = $single["EMAIL"];
        $fname = $single["FNAME"];
        $lname = $single["LNAME"];
        $state = $single["STATE"];
        $country = $single["COUNTRY"];
        $gender = $single["GENDER"];

        if (isset($gender) && strlen(trim($gender)) > 0) {

            if ($gender == 1)
                $gender = "MALE";
            else
                $gender = "FEMALE";
        }

        $result = $mailChimp->call('lists/member-info', array(
            'id' => $list_id,
            'emails' => array(0 => array('email' => $email))
        ));

        if (isset($result["data"][0]["status"]) && $result["data"][0]["status"] == "unsubscribed") {
            echo $result["data"][0]["email"] . " is " . $result["data"][0]["status"] . ", not changing values<br/>";
        } else if (isset($result["data"][0]["status"]) && $result["data"][0]["status"] == "subscribed") {
            echo $result["data"][0]["email"] . " is " . $result["data"][0]["status"] . ", not changing values<br/>";
        } else {
//            $result = $mailChimp->call('lists/subscribe', array(
//                'id' => $list_id,
//                'email' => array('email' => $email),
//                'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname, 'STATE' => $state, 'COUNTRY' => $country, 'GENDER' => $gender),
//                'double_optin' => false,
//                'update_existing' => true,
//                'replace_interests' => false,
//                'send_welcome' => false,
//            ));

            echo "To add = " . $email . " , $gender <br/>";
        }
    }

//    echo "\nMailchimp Synchronize Task Completed at : " . date("Y-m-d h:i:s");
}
<?php
//exit;
//Created By Fahim Khan, for Mailchimp's Email merge field automatically Execute... at 5 o'clock everyday.
ini_set('max_execution_time',1800);
require_once 'app/Mage.php';

Mage::app('');
umask(0);
/*
    $csvFile = file('mailchimp_export.csv');
        $data = array();
        $emails = array();
    foreach ($csvFile as $line) {
            $data[] = str_getcsv($line);
    }
    for($i=1;$i <count($data);$i++){
        array_push($emails,$data[$i][0]);

    }
*/

$api_key = 'e49184c3866b4d458797fdffe11f22d8-us3';
$list_id = "40611aba4e"; //New List



    $date_to_look_start = date('Y-m-d', strtotime('-2 day', strtotime(date('Y-m-d'))));
    $date_to_look_end = date('Y-m-d', strtotime(date('Y-m-d')));

    echo $date_to_look_start . " , " . $date_to_look_end . "\n\n";

    $collection = Mage::getModel('customer/customer')->getCollection()
        ->addAttributeToSelect('entity_id')
        ->addAttributeToSelect('firstname')
        ->addAttributeToSelect('lastname')
        ->addAttributeToSelect('gender')
        ->addAttributeToSelect('email')
        ->addAttributeToFilter('created_at', array('gteq' => $date_to_look_start . ' 00:00:01'))
        ->addAttributeToFilter('created_at', array('lteq' => $date_to_look_end . ' 23:59:59'));
    //echo "<pre/>";
    //print_r($collection->getData('email'));
    //echo count($collection).'<br/>';
    if($collection && count($collection)==0){
        echo "No records found";
        return;
    }

    foreach ($collection as $item) {
                $row = $item->getData();

                $customerId = $row['entity_id'];
                /*
                    $customer = Mage::getModel('customer/customer')->load($customerId);

                    $customerAddress = null;

                    foreach ($customer->getAddresses() as $address) {
                    $customerAddress = $address->toArray();
                    break;
                    }

                    $country = "";
                    $state = "";
                    if($customerAddress){
                            $country = Mage::app()->getLocale()->getCountryTranslation($customerAddress['country_id']);
                            $state = $customerAddress['region'];
                    }
                */

            $batch[] = array(
                'EMAIL' => $row['email'],
                'FNAME' => $row['firstname'],
                'LNAME' => $row['lastname'],
              //  'STATE' => $state,
              //  'COUNTRY' => $country,
                'CUSTOMERID'=> $customerId,
                'GENDER' => $row['gender']
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
            $custId = $single['CUSTOMERID'];
           //$state = $single["STATE"];
           // $country = $single["COUNTRY"];
            $gender = $single["GENDER"];

               if(isset($gender) && strlen(trim($gender))>0){

                    if($gender==1)
                        $gender = "MALE";
                    else
                        $gender = "FEMALE";
                }

            $result = $mailChimp->call('lists/member-info', array(
                'id' => $list_id,
                'emails' => array( 0 => array('email' => $email) )
            ));

            //if($custId == 44732){


                if(isset($result["data"][0]["status"]) && $result["data"][0]["status"]=="subscribed"){

                        $result = $mailChimp->call('lists/subscribe', array(
                            'id' => $list_id,
                            'email' => array('email' => $email),
                            'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname, 'GENDER' => $gender, 'MAILSOURCE' => 'Magento','MMERGE19'=>'Yes'),
                            'double_optin' => false,
                            'update_existing' => true,
                            'replace_interests' => false,
                            'send_welcome' => false,
                        ));

                        echo $email . " , $gender \n";

                }

            //}

    }

    echo "\nMailchimp Synchronize Task Completed at : " . date("Y-m-d h:i:s");

?>
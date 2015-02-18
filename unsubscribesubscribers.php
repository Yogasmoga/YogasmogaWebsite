<?php
    require 'app/Mage.php';

    Mage::app();

    // Set path to CSV file
    $csvFile = 'tounsubscribe.csv';

    $emails = array();

    $file_handle = fopen($csvFile, 'r');
    $firstLine = true;
    $count = 0;
    while (!feof($file_handle)) {
        $ar_line = fgetcsv($file_handle, 1024);
        $email = $ar_line[0];
        $emails[$email] = $email;
        $count++;
    }
    fclose($file_handle);

    echo "<h3>Subscribers to unsubscribe = " . $count . "</h3><br/>";

    $count = 0;
    $coundNotFound = 0;
    if($emails && is_array($emails) && count($emails)>0) {

        foreach ($emails as $email) {

            $customer = Mage::getModel("customer/customer");

            $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
            $customer->loadByEmail($email);

            if(strlen($customer->getId())===0){
                ++$coundNotFound;
                echo "<span style='color:red'>Customer not found with email</span> : <span style='color:blue'>$email</span><br/><br/>";
            }
            else if ($customer) {
                echo ++$count . ". $email <br/>";
                echo "Customer found: id = " . $customer->getId() . "<br/><br/>";
            }
            else {
                echo "No email found : " . $email;
            }
        }

        if($coundNotFound>0){
            echo "<h2>Customers not found in database with given emails = " . $coundNotFound . "</h2>";
        }
    }

?>
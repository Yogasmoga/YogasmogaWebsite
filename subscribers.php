<?php
    require 'app/Mage.php';

    Mage::app();

//    // Set path to CSV file
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
    $countNotFound = 0;
    if($emails && is_array($emails) && count($emails)>0) {

        foreach ($emails as $email) {

            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);

            if($subscriber){
                $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED);
                try {
                    $subscriber->save();
                    echo ++$count . ". $email unsubscribed <br/>";
                } catch (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            }
            else {
                echo "No email found : " . $email;
            }
        }

        if($countNotFound>0){
            echo "<h2>Subscribers not found in database with given emails = " . $countNotFound . "</h2>";
        }
    }

?>
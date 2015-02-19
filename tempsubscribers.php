<?php
    require 'app/Mage.php';

    Mage::app();

    $emails = array();

    $emails[] = "er.brahmdev@gmail.com";
    $emails[] = "anuk@gmail.com";
    $emails[] = "ashutoshpandey.in@gmail.com";

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
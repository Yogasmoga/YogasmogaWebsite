<?php
    require 'app/Mage.php';

    Mage::app();

    $email = $_REQUEST['email'];

    $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);

    if($subscriber){
        $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED);
        try {
            $subscriber->save();
            echo $email . " unsubscribed <br/>";
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    else {
        echo "No subscriber found with email : " . $email;
    }
?>
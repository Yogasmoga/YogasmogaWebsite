<?php
$email = $_REQUEST['email'];

require 'app/Mage.php';

Mage::app();

$subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
$subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED);
$subscriber->save();
?>

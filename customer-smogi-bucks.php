<?php
    require 'app/Mage.php';

    Mage::app();

	$email = $_GET['email'];

	$customer = Mage::getModel("customer/customer");
	$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
	$customer->loadByEmail($email);

	$customerId = $customer->getId();

	$store_id = Mage::app()->getStore()->getId();

	$reward_model = Mage::getModel('rewardpoints/stats');
	$points = $reward_model->getPointsCurrent($customerId, $store_id);

	echo json_encode(array('points' => $points));
?>






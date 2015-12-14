<?php
    require 'app/Mage.php';

    Mage::app();

    //$customerIds = array(12516,20424,21335,16130,20423,21346,21347);
	$customerIds = Mage::getModel('customer/customer')->getCollection();
	
	//$customerIds = array(14893);
    foreach($customerIds as $customer) {
		
		$customerId = $customer->getId();
		$store_id = Mage::app()->getStore()->getId();
        $reward_model = Mage::getModel('rewardpoints/stats');
		$points = $reward_model->getPointsCurrent($customerId, $store_id);
		if($points > 0){
		echo $customerId."--Points = $points<br/>";
        }
		//echo "<br/>Removing<br/>";
        //$reward_model->setPointsSpent($points);
        //$reward_model->setCustomerId($customerId);
        //$reward_model->setStoreId($store_id);
        //$reward_model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);
        //$reward_model->save();

        //$points = $reward_model->getPointsCurrent($customerId, $store_id);
        //echo "Points now = $points";
        //echo "<hr/>";
    }
?>
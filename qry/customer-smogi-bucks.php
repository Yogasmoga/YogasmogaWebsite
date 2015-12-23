<?php
    require '../app/Mage.php';

    Mage::app();

	$expire = false;

	if(isset($_REQUEST['expire'])){
		if($_REQUEST['expire']=='y')
			$expire = true;
	}
    
	$customers = Mage::getModel('customer/customer')->getCollection();

	$smogiCount = 0;
    foreach($customers as $customer) {

		$customerId = $customer->getId();
		$customerEmail = $customer->getEmail();
		$store_id = Mage::app()->getStore()->getId();
        $reward_model = Mage::getModel('rewardpoints/stats');
		$points = $reward_model->getPointsCurrent($customerId, $store_id);

		if($points > 0){

			++$smogiCount;

			$smogiBucks = $points;

			echo "$customerId , $smogiBucks <br/>";

			if($expire) {
				$reward_model->setPointsSpent($points);
				$reward_model->setCustomerId($customerId);
				$reward_model->setStoreId($store_id);
				$reward_model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);
				$reward_model->save();
			}

			if($smogiCount>=500) break;
		}
    }

	echo "<br/>Total with smogi bucks = " . $smogiCount;
?>






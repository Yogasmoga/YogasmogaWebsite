<?php
    require '../app/Mage.php';

    Mage::app();

    
	$customerIds = Mage::getModel('customer/customer')->getCollection();
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=data.csv');


	$output = fopen('php://output', 'w');

	fputcsv($output, array('customer id','customer email', 'smogi bucks'));
	
	
	
    foreach($customerIds as $customer) {
		
		$customerId = $customer->getId();
		$customerEmail = $customer->getEmail();
		$store_id = Mage::app()->getStore()->getId();
        $reward_model = Mage::getModel('rewardpoints/stats');
		$points = $reward_model->getPointsCurrent($customerId, $store_id);
		if($points > 0){
			$smogiBucks = $points;
			
			
			$rows = array(
						'customer id'=>$customerId,
						'customer email'=>$customerEmail,
						'smogi bucks'=>$smogiBucks
						);
			
			//echo "<br/>Removing<br/>";
			//$reward_model->setPointsSpent($points);
			//$reward_model->setCustomerId($customerId);
			//$reward_model->setStoreId($store_id);
			//$reward_model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);
			//$reward_model->save();

			//$points = $reward_model->getPointsCurrent($customerId, $store_id);
			//echo "Points now = $points";
			//echo "<hr/>";
			fputcsv($output, $rows);	
		}
    }
?>






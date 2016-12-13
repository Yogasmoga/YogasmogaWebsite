<?php


include_once '../app/Mage.php';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


try {
	$allTypes = Mage::app()->useCache();
	foreach($allTypes as $type => $value) {
		Mage::app()->getCacheInstance()->cleanType($type);
		Mage::dispatchEvent('adminhtml_cache_refresh_type', array('type' => $type));
		echo "{$type} </br>";
	}
	echo 'done';
} catch (Exception $e) {
	echo $e->getMessage();
}


exit;


	$filename = "customers_having_smogi_bucks.csv";
	if(isset($_REQUEST['type'])) {
		$type = $_REQUEST['type'];

		$filename = isset($type) && $type == "all" ? "all_customers_smogi_bucks.csv" : "customers_having_smogi_bucks.csv";
	}

    require '../app/Mage.php';

    Mage::app();

    $customerIds = Mage::getModel('customer/customer')->getCollection();
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=' . $filename);

	$output = fopen('php://output', 'w');

	fputcsv($output, array('customer id','customer email', 'smogi bucks'));
	
	foreach($customerIds as $customer) {
		
		$customerId = $customer->getId();
		$customerEmail = $customer->getEmail();
		$store_id = Mage::app()->getStore()->getId();
        $reward_model = Mage::getModel('rewardpoints/stats');
		$points = $reward_model->getPointsCurrent($customerId, $store_id);

		if(isset($type) && $type=='all') {

				$smogiBucks = $points;


				$rows = array(
					'customer id' => $customerId,
					'customer email' => $customerEmail,
					'smogi bucks' => $smogiBucks
				);

				fputcsv($output, $rows);
		}
		else{

			if ($points > 0) {
				$smogiBucks = $points;


				$rows = array(
					'customer id' => $customerId,
					'customer email' => $customerEmail,
					'smogi bucks' => $smogiBucks
				);

				fputcsv($output, $rows);
			}
		}
    }
?>
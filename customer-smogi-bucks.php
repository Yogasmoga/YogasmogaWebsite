<?php
    require 'app/Mage.php';

    Mage::app();

	$email = $_GET['email'];

	if(isset($email)) {
		$customer = Mage::getModel("customer/customer");
		$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
		$customer->loadByEmail($email);

		if (isset($customer)) {
			$customerId = $customer->getId();
			$store_id = Mage::app()->getStore()->getId();

			$reward_model = Mage::getModel('rewardpoints/stats');
			$points = $reward_model->getPointsCurrent($customerId, $store_id);

			echo json_encode(array('points' => $points, "message" => "Customer found"));

			if (false) {
				//$link = Mage::getBaseUrl().'api/soap/?wsdl';
				$link = Mage::getBaseUrl() . "api/v2_soap/?wsdl";
				$proxy = new SoapClient($link);
				var_dump($proxy);
				//$sessionId = $proxy->login('api_login', 'j2t_apikey');

				//var_dump($proxy->call($sessionId, 'j2trewardapi.info', array($customerId, $storeId)));
			}
		} else
			echo json_encode(array('points' => 0, "message" => "Customer not found"));
	}
	else
		echo json_encode(array('points' => 0, "message" => "No email provided"));
?>
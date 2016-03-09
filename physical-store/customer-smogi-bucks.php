<?php
    require 'app/Mage.php';

    Mage::app();

	$token = $_GET['token'];

	if(isset($token)) {

		if($token==$_SESSION['token']) {

			$email = $_GET['email'];

			if (isset($email)) {
				$customer = Mage::getModel("customer/customer");
				$customer->setWebsiteId(Mage::app()->getWebsite()->getId());
				$customer->loadByEmail($email);

				try {
					$customerId = $customer->getId();
					$storeId = Mage::app()->getStore()->getId();
				} catch (Exception $e) {
					echo json_encode(array('points' => 0, "message" => "not found"));
					die;
				}

				$link = Mage::getBaseUrl() . 'api/soap/?wsdl';
				//$link = Mage::getBaseUrl() . "api/v2_soap/?wsdl";

				$proxy = new SoapClient($link);

				$sessionId = $proxy->login('j2t', 'j2t_apikey');

				$result = $proxy->call($sessionId, 'j2trewardapi.info', array($customerId, $storeId));

				echo json_encode(array('points' => $result["current"], "message" => "found"));
			} else
				echo json_encode(array('points' => 0, "message" => "blank"));
		}
		else
			echo json_encode(array("message" => "logged out"));
	}
	else
		echo json_encode(array("message" => "no token"));

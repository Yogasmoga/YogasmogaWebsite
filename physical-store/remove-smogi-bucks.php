<?php
require '../app/Mage.php';

Mage::app();

$token = $_GET['token'];

if(isset($token)) {

    $existingToken = Mage::getSingleton('core/session')->getToken();
echo "existing token = $existingToken";die;
    if($token==$existingToken) {

        $email = $_GET['email'];
        $used = $_GET['used'];

        if (isset($email) && isset($used) && is_numeric($used)) {
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

            if (isset($result) && isset($result["current"])) {

                try {
                    $currentPoints = intval($result["current"]);

                    if ($currentPoints >= $used) {
                        $proxy->call($sessionId, 'j2trewardapi.remove', array($customerId, $used, $storeId));

                        echo json_encode(array("message" => "done"));
                    } else
                        echo json_encode(array("message" => "insufficient"));
                } catch (Exception $ee) {
                    echo json_encode(array("message" => "error"));
                }
            } else
                echo json_encode(array("message" => "no points"));
        } else
            echo json_encode(array("message" => "wrong data"));
    } else
        echo json_encode(array("message" => "logged out"));
}
else
    echo json_encode(array("message" => "no token"));

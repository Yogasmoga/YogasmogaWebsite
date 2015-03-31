<?php

class Ysindia_Mod_SessionController extends Mage_Core_Controller_Front_Action
{

    public function loggedcustomerAction()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $ar = array(
                'message' => 'logged',
                'user_id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'name' => $customer->getName(),
                'gender' => $customer->getGender(),
                'first_name' => $customer->getFirstname(),
                'middle_name' => $customer->getMiddlename(),
                'last_name' => $customer->getLastname(),
            );
        } else {
            $ar = array('message' => 'notlogged');
        }

        echo json_encode($ar);
    }

    public function getcustomerbyidAction()
    {

        $customer_id = $this->getRequest()->getParam('id');

        $customer = Mage::getSingleton('customer/customer')->load($customer_id);

        if ($customer) {

            $ar = array(
                'message' => 'found',
                'user_id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'name' => $customer->getName(),
                'gender' => $customer->getGender(),
                'first_name' => $customer->getFirstname(),
                'middle_name' => $customer->getMiddlename(),
                'last_name' => $customer->getLastname()
            );
        } else {
            $ar = array('message' => 'invalid');
        }

        echo json_encode($ar);
    }

    public function getcustomerbyemailAction()
    {
        $email = $this->getRequest()->getParam('email');

        $customer = Mage::getModel("customer/customer");
        $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
        $customer->loadByEmail($email);

        if ($customer) {

            $ar = array(
                'message' => 'found',
                'user_id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'name' => $customer->getName(),
                'gender' => $customer->getGender(),
                'first_name' => $customer->getFirstname(),
                'middle_name' => $customer->getMiddlename(),
                'last_name' => $customer->getLastname()
            );
        } else {
            $ar = array('message' => 'invalid');
        }

        echo json_encode($ar);
    }

    public function productsmogibucksAction()
    {

        $product_id = $this->getRequest()->getParam('id');

        $product = Mage::getModel('catalog/product')->load($product_id);

        $productName = $product->getName();

        $rewardPoints = Mage::helper('rewardpoints/data')->getProductPointsText($product, false, false);
        $rewardPoints = strip_tags($rewardPoints);          // remove php and html tags

        // extract 5 from the string 'earn 5 smogi bucks with this purchase'
        $productRewardPoints = trim(substr($rewardPoints, strpos($rewardPoints, "earn") + strlen("earn"), strpos($rewardPoints, "smogi") - 3 - strlen("smogi") - strpos($rewardPoints, "earn") + strlen("earn")));

        $ar = array('product_id' => $product_id, 'product_name' => $productName, 'smogi_bucks' => $productRewardPoints);

        echo json_encode($ar);
    }

    public function customersmogibucksAction()
    {
        $customerId = $this->getRequest()->getParam('id');

        $store_id = Mage::app()->getStore()->getId();

        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)) {
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            $points = $reward_flat_model->collectPointsCurrent($customerId, $store_id);
        } else {
            $reward_model = Mage::getModel('rewardpoints/stats');
            $points = $reward_model->getPointsCurrent($customerId, $store_id);
        }

        $ar = array('customer_id' => $customerId, 'smogi_bucks' => $points);

        echo json_encode($ar);
    }

    public function getrangoliprofilebyidAction()
    {
        $customerId = $this->getRequest()->getParam('id');

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $query = 'SELECT * FROM rangoli_user_profiles where customer_id=' . $customerId;

        $row = $readConnection->fetchAll($query);

        if ($row) {
            $ar = array(
                "message" => "found",
                "id" => $row[0]["id"],
                "user_id" => $row[0]["user_id"],
                "email" => $row[0]["email"],
                "color_main" => $row[0]["color_main"],
                "color_shade" => $row[0]["color_shade"],
                "status" => $row[0]["status"]
            );
        } else
            $ar = array("message" => "invalid");

        echo json_encode($ar);
    }

    public function getloggedrangoliprofileAction()
    {
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $customer = Mage::getSingleton('customer/session')->getCustomer();

            $email = $customer->getEmail();

            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');

            $query = "SELECT id,user_id,email,color_main,color_shade,biodata,user_type,profile_url,status FROM rangoli_user_profiles where email='$email'";

            $row = $readConnection->fetchAll($query);

            if ($row) {
                $ar = array(
                    "message" => "found",
                    "id" => $row[0]["id"],
                    "user_id" => $row[0]["user_id"],
                    "email" => $row[0]["email"],
                    "color_main" => $row[0]["color_main"],
                    "color_shade" => $row[0]["color_shade"],
                    "biodata" => $row[0]["biodata"],
                    "user_type" => $row[0]["user_type"],
                    "profile_url" => $row[0]["profile_url"],
                    "status" => $row[0]["status"]
                );
            } else
                $ar = array("message" => "invalid");

        } else {
            $ar = array('message' => 'notlogged');
        }

        echo json_encode($ar);
    }

    public function getrangoliuserAction()
    {
        $customer_id = $this->getRequest()->getParam('id');

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $customer = Mage::getSingleton('customer/customer')->load($customer_id);

        if ($customer) {

            $query = "SELECT id,user_login,user_pass,user_nicename,user_email,user_url,user_registered,user_activation_key,user_status,display_name FROM rangoli_users where user_email='" . $customer->getEmail() . "'";

            $results = $readConnection->fetchAll($query);

            if ($results && count($results) == 1) {
                $ar = $results[0];
                $ar["message"] = "found";
            } else
                $ar["message"] = "invalid";

        } else {
            $ar = array('message' => 'invalid');
        }

        echo json_encode($ar);
    }


    public function getrangoliuserbyemailAction()
    {
        $email = $this->getRequest()->getParam('email');

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');

        $query = "SELECT id,user_login,user_pass,user_nicename,user_email,user_registered,user_activation_key,user_status,display_name FROM rangoli_users where user_email='$email'";

        $row = $readConnection->fetchAll($query);

        if ($row) {
            $ar = array(
                "message" => "found",
                "id" => $row[0]["id"],
                "user_login" => $row[0]["user_login"],
                "user_pass" => $row[0]["user_pass"],
                "user_nicename" => $row[0]["user_nicename"],
                "user_registered" => $row[0]["user_registered"],
                "user_activation_key" => $row[0]["user_activation_key"],
                "user_status" => $row[0]["user_status"],
                "display_name" => $row[0]["display_name"]
            );
        } else
            $ar = array("message" => "invalid");

        echo json_encode($ar);
    }

    public function updaterangolisubscribedauthorsstatusAction()
    {
        $author_id = $this->getRequest()->getParam('author_id');
        $subscriber_id = $this->getRequest()->getParam('subscriber_id');
        $status = $this->getRequest()->getParam('status');

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $writeConnection = $resource->getConnection('core_write');

        $query = 'SELECT id FROM rangoli_wpsa_subscribe_author where author_id=' . $author_id . ' and subscriber_id=' . $subscriber_id;

        $row = $readConnection->fetchAll($query);

        if ($row) {
            $query = "UPDATE rangoli_wpsa_subscribe_author SET status='" . $status . "' WHERE author_id=" . $author_id . " and subscriber_id=" . $subscriber_id;
        } else {
            $query = "insert into rangoli_wpsa_subscribe_author(author_id,subscriber_id,created_at,updated_at,status) values($author_id, $subscriber_id, '" . date('Y-m-d h:i:s') . "','" . date('Y-m-d h:i:s') . "','active')";
        }


        $result = $writeConnection->query($query);
        if ($result) {
            $ar = array(
                "message" => "success");
        } else {
            $ar = array("message" => "invalid");
        }
        echo json_encode($ar);
    }

    public function updaterangoliuserstatusAction()
    {
        $user_id = $this->getRequest()->getParam('user_id');

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $writeConnection = $resource->getConnection('core_write');

        $query = 'SELECT id FROM rangoli_user_profiles where user_id=' . $user_id;

        $row = $readConnection->fetchAll($query);

        if ($row) {
            $query = "UPDATE rangoli_user_profiles SET status='old' WHERE user_id=" . $user_id;
        }


        $result = $writeConnection->query($query);
        if ($result) {
            $ar = array(
                "message" => "success");
        } else {
            $ar = array("message" => "invalid");
        }
        echo json_encode($ar);
    }

    public function customertotalsmogibucksAction()
    {
        $customer_id = $this->getRequest()->getParam('id');

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $customer = Mage::getSingleton('customer/customer')->load($customer_id);

        if ($customer) {

            $query = "SELECT points_current,points_spent FROM rewardpoints_account where customer_id=$customer_id";

            $results = $readConnection->fetchAll($query);

            if ($results && count($results) > 0) {

                $total = 0;
                foreach ($results as $result) {
                    $total += intval($result["points_current"]);
                    $total += intval($result["points_spent"]);
                }

                echo $total;
            } else
                echo 0;
        } else
            echo -1;
    }


    public function getcartcountAction(){
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {

            $count = Mage::helper('checkout/cart')->getSummaryCount();

            echo $count;
        }
        else
            echo 0;
    }


}

?>
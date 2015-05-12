<?php

class Ankitsinghania_Smogiexpirationnotifier_Model_Notify extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('smogiexpirationnotifier/notify');
        parent::_construct();
    }

    public function notify()
    {
        Mage::log("i ran", null, "smoginotifier.log");
        $this->getCustomerslist(20);
    }

    public function notifyusers()
    {
        Mage::log("notifying users", null, "smoginotifier.log");
        $notification_periods = array(4, 30);
        $serverType = Mage::getModel('core/variable')->loadByCode('server_type')->getValue('plain');
        foreach ($notification_periods as $notification_period) {
            $customerlist = $this->getCustomerslist($notification_period);
            $notify_date = date('Y-m-d');
            $bucks_expiration_date = date('Y-m-d', strtotime(" + " . $notification_period . " days"));
            $bucks_expiration_date_string = date('F jS, Y', strtotime($bucks_expiration_date . " - 1 day"));
            foreach ($customerlist as $customer) {
                $email = $customer['customer_email'];

                if (!$this->isUnsubscribed($email)) {

                    $notification_log = Mage::getModel('smogiexpirationnotifier/notify');
                    $notification_log->setCustomer_id($customer['customer_id']);
                    $notification_log->setCustomer_email($customer['customer_email']);
                    $notification_log->setCustomer_name($customer['customer_name']);
                    $notification_log->setBucks_expiring($customer['bucks_expiring']);
                    $notification_log->setBucks_expiration_date($bucks_expiration_date);
                    $notification_log->setNotify_date($notify_date);
                    if ($serverType == 'production')
                        $notification_log->setEmail_status($this->sendemail($customer['customer_name'], $customer['customer_email'], $customer['bucks_expiring'], $notification_period, $bucks_expiration_date_string));
                    else
                        //$notification_log->setEmail_status($this->sendemail($customer['customer_name'], "ankit@mobikasa.com", $customer['bucks_expiring'], $notification_period, $bucks_expiration_date_string));
                    $notification_log->setEmail_status(0);
                    $notification_log->setNotification_period($notification_period);
                    $notification_log->save();
                }
            }
        }
    }

    public function isUnsubscribed($email)
    {
        $root = Mage::getBaseDir();

        $myfile = fopen($root . "/mailchimp_list.txt", "r") or die("Unable to open file!");
        $apikey_listid = trim(fgets($myfile));
        fclose($myfile);

        $ar = explode(",", $apikey_listid);

        $api_key = trim($ar[0]);
        $list_id = trim($ar[1]);

        include($root . "/mailchimpapi/Drewm/MailChimp.php");

        $mailChimp = new Drewm\MailChimp($api_key);

        $result = $mailChimp->call('lists/member-info', array(
            'id' => $list_id,
            'emails' => array( 0 => array('email' => $email) )
        ));

        if(isset($result["data"][0]["status"]) && $result["data"][0]["status"]=="unsubscribed"){
            return true;
        }
        else if(isset($result["data"][0]["status"]) && $result["data"][0]["status"]=="subscribed"){
            return false;
        }
        else{
            return true;
        }
    }

    public function getCustomerslist($expiring_in_days)
    {
        $allStores = Mage::app()->getStores();
        $customerlist = array();
        foreach ($allStores as $_eachStoreId => $val) {
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            $days = $expiring_in_days;
            /*	$points = Mage::getModel('rewardpoints/stats')
                            ->getResourceCollection()
                            ->addFinishFilter($days)
                            ->addValidPoints($store_id);
                if ($points->getSize()){
                    foreach ($points as $current_point){
                        $customer_id = $current_point->getCustomerId();
                        $points = $current_point->getNbCredit();
                        $customer = Mage::getModel('customer/customer')->load($customer_id);
                        $customerName = $customer->getName();
                        $customerEmail = $customer->getEmail();
                        array_push($customerlist, array("customer_id" => $customer_id, "customer_email" => $customerEmail, "customer_name" => $customerName,"bucks_expiring" => $points));
                    }
                }*/
            $resource = Mage::getSingleton('core/resource');
            //$writeConnection = $resource->getConnection('core_write');
            $readConnection = $resource->getConnection('core_write');
            $temp = $readConnection->query("Select entity_id from customer_entity where is_active=1");
            $date = date('Y-m-d');
            $dateAfter = date('Y-m-d', strtotime($date . ' + ' . $days . ' day'));
            while ($customerId = $temp->fetch()) {
                $customer = Mage::getModel('customer/customer')->load($customerId);
                $customerName = $customer->getName();
                $customerEmail = $customer->getEmail();
                $customer_id = $customer->getId();
                //$expireSmogiBucks = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id) - Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id,$store_id,$dateAfter);

                $afterSmogiArrray = Mage::getModel('rewardpoints/stats')->getPointsCurrent($customer_id, $store_id, $dateAfter, true);
                $afterBalance = 0;

                foreach ($afterSmogiArrray["history"] as $smogi1) {
                    if (strtotime($dateAfter) == strtotime($smogi1["date_end"])) {
                        $afterBalance += $smogi1["balance"];

                    }
                }

                $expireSmogiBucks = $afterBalance;
                if ($expireSmogiBucks > 0) {
                    array_push($customerlist, array("customer_id" => $customer_id, "customer_email" => $customerEmail, "customer_name" => $customerName, "bucks_expiring" => $expireSmogiBucks));
                }

            }

        }
        return $customerlist;
    }

    public function sendemail($recipient_name, $recipient_email, $bucks, $expiry_days, $expiration_date)
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');
        //$template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        //$template = 1;
//        $template = Mage::getModel('core/email_template')->loadByCode('testemail');
        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code', 'smogi_expiring_notification_email');
        $template_id = $mail_collection->getFirstItem()->getTemplate_id();

        $recipient = array(
            'email' => $recipient_email,
            'name' => $recipient_name
        );
        $sender = array(
            'name' => 'YOGASMOGA',
            'email' => 'hello@yogasmoga.com'
        );
        $email->setDesignConfig(array('area' => 'frontend', 'store' => Mage::app()->getStore()->getId()))
            ->sendTransactional(
                $template_id,
                $sender,
                $recipient['email'],
                $recipient['name'],
                array(
                    'bucks' => $bucks,
                    'days_to_expire' => $expiry_days,
                    'expiration_date' => $expiration_date
                )
            );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }
}

?>
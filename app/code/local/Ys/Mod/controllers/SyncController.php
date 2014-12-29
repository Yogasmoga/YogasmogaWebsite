<?php
class Ys_Mod_SyncController extends Mage_Core_Controller_Front_Action {

    public function unsubscribeAction() {

        $myfile = fopen("mailchimp_list.txt", "r") or die("Unable to open file!");
        $apikey_listid = trim(fgets($myfile));
        fclose($myfile);

        $ar = explode(",", $apikey_listid);

        $api_key = trim($ar[0]);
        $list_id = trim($ar[1]);

        $correct = isset($api_key) && isset($list_id) && (strlen($list_id) > 0) && (strlen($api_key) > 0);

        if ($correct) {

            $data = $this->getRequest()->getPrams();

            $email = $data['data']['email'];

            $subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
            if (!$subscriber->getId()
                || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED
                || $subscriber->getStatus() == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                Mage::log("Subscriber not found");
            }
            else{
                $subscriber->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED);
                $subscriber->save();
                Mage::log("Mailchimp Unsubscribe Task Completed at : " . date("Y-m-d h:i:s"));
            }

        } else
            Mage::log("I guess api key or list id are invalid");
    }
}


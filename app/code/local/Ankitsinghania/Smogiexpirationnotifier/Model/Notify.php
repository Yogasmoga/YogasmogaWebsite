<?php
class Ankitsinghania_Smogiexpirationnotifier_Model_Notify extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('smogiexpirationnotifier/notify');
        parent::_construct();
    }
    public function notify(){
        Mage::log("i ran", null, "smoginotifier.log");
    }
    
    public function getCustomerslist($expiring_in_days)
    {
        $allStores = Mage::app()->getStores();	
        $customerlist = array();
        foreach ($allStores as $_eachStoreId => $val)
        {
            $store_id = Mage::app()->getStore($_eachStoreId)->getId();
            $days = $expiring_in_days;
			$points = Mage::getModel('rewardpoints/stats')
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
                    array_push($customerlist, array($customer_id, $customerEmail, $customerName, $points));
                }
            }
        }
        return $customerlist;
    }
    
    public function sendemail($recipient_name, $recipient_email, $bucks, $expiry_days)
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');
        //$template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        //$template = 1;
//        $template = Mage::getModel('core/email_template')->loadByCode('testemail');
        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code','testemail');
        $template_id = $mail_collection->getFirstItem()->getTemplate_id();
        
        $recipient = array(
            'email' => $recipient_email,
            'name'  => $recipient_name
        );
        $sender  = array(
            'name' => 'YOGASMOGA',
            'email' => 'hello@yogasmoga.com'
        );
        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template_id,
                    $sender,
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'bucks'        => $bucks,
                        'days_to_expire' => $expiry_days
                    )
                );
        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }
}
?>
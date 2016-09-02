<?php
class Ankitsinghania_Abandonedcartreminder_Model_Notify extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('abandonedcartreminder/notify');
        parent::_construct();
    }
    
    public function remindusers()
    {
        Mage::log("i ran", null, "abandonedcartreminder.log");
    }
    
    public function sendemail($recipient_name, $recipient_email, $bucks, $expiry_days)
    {
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        $email = Mage::getModel('core/email_template');
        //$template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        //$template = 1;
//        $template = Mage::getModel('core/email_template')->loadByCode('testemail');
        $mail_collection = Mage::getModel('core/email_template')->getCollection()->addFieldToFilter('template_code','smogi_expiring_notification_email');
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
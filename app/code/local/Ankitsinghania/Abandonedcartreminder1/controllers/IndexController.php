<?php
class Ankitsinghania_Abandonedcartreminder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
        echo "hello from abandoned cart module";
        return;
        Mage::getModel('abandonedcartreminder/notify')->notify();
        return;
    }
    
    public function notifyusersAction()
    {
        Mage::getModel('abandonedcartreminder/notify')->notifyusers();
    }
    
    public function createnotificationAction()
    {
        $notifications = Mage::getModel('smogiexpirationnotifier/notify');
        $notifications->setCustomer_id(1);
        $notifications->setCustomer_email("ankit@mobikasa.com");
        $notifications->setBucks_expiring(10);
        $notifications->setBucks_expiration_date('2014-02-02');
        $notifications->setNotify_date('2014-02-02');
        $notifications->save();
        echo "Saved with id = ".$notifications->getId();
    }
    
    public function sendemailAction()
    {
        echo Mage::getModel('abandonedcartreminder/notify')->sendemail("Manish Waliyan","ankit@mobikasa.com",100, 45);
    }
}
?>
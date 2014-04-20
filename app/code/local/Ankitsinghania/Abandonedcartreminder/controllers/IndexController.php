<?php
class Ankitsinghania_Abandonedcartreminder_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
        echo "hello from Abandonedcartreminder extension.";
        return;
        
        Mage::getModel('smogiexpirationnotifier/notify')->notify();
        return;
        echo "Am I working ??";
        $notifications = Mage::getModel('smogiexpirationnotifier/notify');
        $notifications->load(1);
        $notifications->delete();
        return;
        $collection = Mage::getModel('smogiexpirationnotifier/notify')->getCollection();
        foreach($collection as $data)
        {
             //$retour .= $data->getData('nom').' '.$data->getData('prenom').' '.$data->getData('telephone').'<br />';
             echo $data->getData('customer_email')."<br/>";
        }
    }
    
    public function notifyusersAction()
    {
        Mage::getModel('smogiexpirationnotifier/notify')->notifyusers();
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
        echo Mage::getModel('smogiexpirationnotifier/notify')->sendemail("Manish Waliyan","ankit@mobikasa.com",100, 45);
    }
}
?>
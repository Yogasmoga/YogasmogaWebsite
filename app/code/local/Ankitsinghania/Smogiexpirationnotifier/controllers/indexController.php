<?php
class Ankitsinghania_Smogiexpirationnotifier_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction(){
        Mage::getModel('smogiexpirationnotifier/notify')->notify();
        echo "Am I working ??";
    }
}
?>
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
}
?>
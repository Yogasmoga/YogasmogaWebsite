<?php

class Mailchimp_Mod_Block_Adminhtml_Custom extends Mage_Adminhtml_Block_Template {

    public function getMessage()
    {
        $message = Mage::getSingleton('core/session')->getMessage();
        return $message;
    }
}
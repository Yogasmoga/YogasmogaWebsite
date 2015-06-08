<?php

class Ysindia_Emailjourney_Model_Mysql4_Journey extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
    	
        $this->_init('journey/journey', 'id');
        
        
    }
}
<?php

class Ysindia_Vivacity_Model_Mysql4_Vivacity extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the vivacity_id refers to the key field in your database table.
        $this->_init('vivacity/vivacity', 'id');
    }
}
<?php

class Ysindia_Sharesmogi_Model_Mysql4_Sharesmogi extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the sharesmogi_id refers to the key field in your database table.
        $this->_init('sharesmogi/sharesmogi', 'sharesmogi_id');
    }
}
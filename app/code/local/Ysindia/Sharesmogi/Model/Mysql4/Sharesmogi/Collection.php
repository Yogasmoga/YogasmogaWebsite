<?php

class Ysindia_Sharesmogi_Model_Mysql4_Sharesmogi_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sharesmogi/sharesmogi');
    }
}
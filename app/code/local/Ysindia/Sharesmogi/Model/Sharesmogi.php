<?php

class Ysindia_Sharesmogi_Model_Sharesmogi extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sharesmogi/sharesmogi');
    }
}
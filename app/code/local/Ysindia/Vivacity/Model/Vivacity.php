<?php

class Ysindia_Vivacity_Model_Vivacity extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vivacity/vivacity');
    }
}
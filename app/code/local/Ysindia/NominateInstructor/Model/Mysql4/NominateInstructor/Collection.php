<?php

class Ysindia_NominateInstructor_Model_Mysql4_NominateInstructor_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('nominateinstructor/nominateinstructor');
    }
}
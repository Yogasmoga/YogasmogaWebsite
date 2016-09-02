<?php

class Ysindia_Nominateinstructor_Model_Mysql4_Nominateinstructor_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('nominateinstructor/nominateinstructor');
    }
}
<?php

class Ysindia_Nominateinstructor_Model_Mysql4_Nominateinstructor extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the nominateinstructor_id refers to the key field in your database table.
        $this->_init('nominateinstructor/nominateinstructor', 'nominateinstructor_id');
    }
}
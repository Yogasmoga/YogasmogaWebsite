<?php
class Ysindia_Emailjourney_Model_Mysql4_Journey_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{ 
    public function __construct()
    {
		$this->_init('journey/journey');
    }
}
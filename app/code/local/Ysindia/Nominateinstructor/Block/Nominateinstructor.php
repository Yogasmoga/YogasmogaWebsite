<?php
class Ysindia_Nominateinstructor_Block_Nominateinstructor extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getNominateInstructor()     
     { 
        if (!$this->hasData('nominateinstructor')) {
            $this->setData('nominateinstructor', Mage::registry('nominateinstructor'));
        }
        return $this->getData('nominateinstructor');
        
    }
}
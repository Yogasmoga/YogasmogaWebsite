<?php
class Ysindia_Vivacity_Block_Vivacity extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getVivacity()     
     { 
        if (!$this->hasData('vivacity')) {
            $this->setData('vivacity', Mage::registry('vivacity'));
        }
        return $this->getData('vivacity');
        
    }
}
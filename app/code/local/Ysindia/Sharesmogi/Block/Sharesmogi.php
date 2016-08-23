<?php
class Ysindia_Sharesmogi_Block_Sharesmogi extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSharesmogi()     
     { 
        if (!$this->hasData('sharesmogi')) {
            $this->setData('sharesmogi', Mage::registry('sharesmogi'));
        }
        return $this->getData('sharesmogi');
        
    }
}
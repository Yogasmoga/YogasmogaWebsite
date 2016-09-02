<?php
class Ysindia_Vivacity_IndexController extends Mage_Core_Controller_Front_Action
{
    public function saveAction()
    {
		$size = $this->getRequest()->getParam('size');
		$session = Mage::getSingleton('core/session')->setSize($size);
		
		echo Mage::getSingleton('core/session')->getSize();
    	
    }
}
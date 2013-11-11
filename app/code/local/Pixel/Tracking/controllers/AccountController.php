<?php
require_once 'Mage/Customer/controllers/AccountController.php';

class Pixel_Tracking_AccountController extends Mage_Customer_AccountController
{
   
	
	 public function indexAction()
    {
        $this->loadLayout();
		
		
		if (Mage::getSingleton('customer/session')->getCustomerRegistered() == 'yes')
		{
			
		$block = $this->getLayout()->createBlock('customer/account_dashboard');       
		$this->getLayout()->getBlock('head')->addJs('pixel_tracking_registration.js');                 
		$this->getLayout()->getBlock('head')->append($block);
		
		}
		
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');

        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
		
        $this->renderLayout();
		return $this;
    }
	
	
	
}
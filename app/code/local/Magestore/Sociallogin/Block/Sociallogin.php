<?php
class Magestore_Sociallogin_Block_Sociallogin extends Mage_Core_Block_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('sociallogin/sociallogin_buttons.phtml');
	}
	
	public function isShowFaceBookButton()
	{
		return (int) Mage::getStoreConfig('sociallogin/fblogin/is_active',Mage::app()->getStore()->getId());
	}
	
	public function isShowGmailButton()
	{
		return (int) Mage::getStoreConfig('sociallogin/gologin/is_active',Mage::app()->getStore()->getId());
	}
	
	public function isShowTwitterButton()
	{
		return (int) Mage::getStoreConfig('sociallogin/twlogin/is_active',Mage::app()->getStore()->getId());
	}
	
	public function isShowYahooButton()
	{
		return (int) Mage::getStoreConfig('sociallogin/yalogin/is_active',Mage::app()->getStore()->getId());
	}	
	
	public function getDirection()
	{
		return Mage::getStoreConfig('sociallogin/general/direction',Mage::app()->getStore()->getId());
	}
	
	public function getIsActive()
	{
		return (int) Mage::getStoreConfig('sociallogin/general/is_active',Mage::app()->getStore()->getId());
	}	
	
	public function getFacebookButton()
	{
		return $this->getLayout()->createBlock('sociallogin/fblogin')
					->setTemplate('sociallogin/bt_fblogin.phtml')->toHtml();
		
	}
	
	public function getGmailButton()
	{
		return $this->getLayout()->createBlock('sociallogin/gologin')
					->setTemplate('sociallogin/bt_gologin.phtml')->toHtml();
	
	}

	public function getTwitterButton()
	{
		return $this->getLayout()->createBlock('sociallogin/twlogin')
					->setTemplate('sociallogin/bt_twlogin.phtml')->toHtml();
		
	}

	public function getYahooButton()
	{
		return $this->getLayout()->createBlock('sociallogin/yalogin')
					->setTemplate('sociallogin/bt_yalogin.phtml')->toHtml();
	}	
	
	protected function _beforeToHtml()
	{
		if(!$this->getIsActive()){
			$this->setTemplate(null);
		}
		
		if(!Mage::helper('magenotification')->checkLicenseKey('Sociallogin')){
			$this->setTemplate(null);
		}			
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()){
			$this->setTemplate(null);
		}
		
		if(Mage::registry('shown_sociallogin_button')){
			$this->setTemplate(null);
		} elseif($this->getTemplate()){
			Mage::register('shown_sociallogin_button',true);
		}
		
		return parent::_beforeToHtml();
	}	
}
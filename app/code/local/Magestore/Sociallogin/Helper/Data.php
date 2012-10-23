<?php
class Magestore_Sociallogin_Helper_Data extends Mage_Core_Helper_Abstract{
	public function getCustomerByEmail($email){
		return Mage::getModel('customer/customer')->getCollection()
					->addFieldToFilter('email', $email)
					->getFirstItem();
	}
	
	public function createCustomer($data){
		$customer = Mage::getModel('customer/customer')
					->setFirstname($data['firstname'])
					->setLastname($data['lastname'])
					->setEmail($data['email']);
					
		$isSendPassToCustomer = Mage::getStoreConfig('sociallogin/yalogin/is_send_password_to_customer');
		$newPassword = $customer->generatePassword();
		$customer->setPassword($newPassword);
		try{
			$customer->save();
		}catch(Exception $e){}
		
		if($isSendPassToCustomer)
			$customer->sendPasswordReminderEmail();
		return $customer;
	}
	
	public function getTwConsumerKey(){
		return Mage::getStoreConfig('sociallogin/twlogin/consumer_key');
	}
	
	public function getTwConsumerSecret(){
		return Mage::getStoreConfig('sociallogin/twlogin/consumer_secret');
	}
	
	public function getTwConnectingNotice(){
		return Mage::getStoreConfig('sociallogin/twlogin/connecting_notice');
	}
	
	public function getYaAppId(){
		return Mage::getStoreConfig('sociallogin/yalogin/app_id');
	}
	
	public function getYaConsumerKey(){
		return Mage::getStoreConfig('sociallogin/yalogin/consumer_key');
	}
	
	public function getYaConsumerSecret(){
		return Mage::getStoreConfig('sociallogin/yalogin/consumer_secret');
	}
	
	public function getGoConsumerKey(){
		return Mage::getStoreConfig('sociallogin/gologin/consumer_key');
	}
	
	public function getGoConsumerSecret(){
		return Mage::getStoreConfig('sociallogin/gologin/consumer_secret');
	}
	
	public function getFbAppId(){
		return Mage::getStoreConfig('sociallogin/fblogin/app_id');
	}
	
	public function getFbAppSecret(){
		return Mage::getStoreConfig('sociallogin/fblogin/app_secret');
	}
	
	public function getAuthUrl(){
		$isSecure = Mage::getStoreConfig('web/secure/use_in_frontend');
		return $this->_getUrl('sociallogin/fblogin/login', array('_secure'=>$isSecure, 'auth'=>1));
	}
	
	public function getDirectLoginUrl(){
		$isSecure = Mage::getStoreConfig('web/secure/use_in_frontend');
		return $this->_getUrl('sociallogin/fblogin/login', array('_secure'=>$isSecure));
	}
	
	public function getLoginUrl(){
		$isSecure = Mage::getStoreConfig('web/secure/use_in_frontend');
		return $this->_getUrl('customer/account/login', array('_secure'=>$isSecure));
	}
}
<?php

class Magestore_Sociallogin_YaloginController extends Mage_Core_Controller_Front_Action{
	
	// url to login
    public function loginAction() {
		if(!Mage::helper('magenotification')->checkLicenseKeyFrontController($this)){return;}
		$yalogin = Mage::getModel('sociallogin/yalogin');
		$hasSession = $yalogin->hasSession();
		if($hasSession == FALSE) {
			$authUrl = $yalogin->getAuthUrl();			
			$this->_redirectUrl($authUrl);
		}else{
			$session = $yalogin->getSession();
			$userSession = $session->getSessionedUser();
			$profile = $userSession->loadProfile();
			$emails = $profile->emails;
			$user = array();
			foreach($emails as $email){
				if($email->primary == 1)
					$user['email'] = $email->handle;
			}
			$user['firstname'] = $profile->givenName;
			$user['lastname'] = $profile->familyName;
			
			$customer = Mage::helper('sociallogin')->getCustomerByEmail($user['email']);
			if(!$customer || !$customer->getId()){
				$customer = Mage::helper('sociallogin')->createCustomer($user);
				if (Mage::getStoreConfig('sociallogin/yalogin/is_send_password_to_customer')){
					$customer->sendPasswordReminderEmail();
				}
			}
			
			Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
			die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
			//$this->_redirectUrl(Mage::helper('customer')->getDashboardUrl());
		}
		
    }
	
	public function testAction(){
		
	}
}
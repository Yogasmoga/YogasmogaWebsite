<?php
class Magestore_Sociallogin_MploginController extends Mage_Core_Controller_Front_Action{
	/**
	* getToken and call profile user myspace
	**/
    public function loginAction() {
		if(!Mage::helper('magenotification')->checkLicenseKeyFrontController($this)){return;}
		$requestToken = Mage::getSingleton('core/session')->getRequestToken();
		if(!Mage::helper('magenotification')->checkLicenseKeyFrontController($this)){return;}
		$mp = Mage::getModel('sociallogin/mplogin')->newMp($requestToken);
		$oauth_token = $this->getRequest()->getParam('oauth_token');
        $oauth_verifier = $this->getRequest()->getParam('oauth_verifier');		
		$accessToken = $mp->accessToken($oauth_verifier, urldecode ($oauth_token));
		$userId = $mp->get('http://api.myspace.com/v1/user.json')->userId;		
		$data = $mp->get( 'http://api.myspace.com/v1/users/' . $userId . '/profile.json' );		
		if ( ! is_object( $data ) ){			
			Mage::getSingleton('core/session')->addError('Login failed as you have not granted access.');			
			die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");	
		}				
		
		$customerId = $this->getCustomerId($userId);
		
		if (!$customerId){			
			$name = $data->basicprofile->name;
			$email = $userId . '@myspace.com';
			$user['firstname'] = $name;
			$user['lastname'] = $name;
			$user['email'] = $email;
			$customer = Mage::helper('sociallogin')->createCustomer($user);									
			Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);							
			Mage::getSingleton('core/session')->setCustomerIdSocialLogin($userId);			
			$this->setAuthorCustomer($userId, $customer->getId());				
			if (Mage::getStoreConfig('sociallogin/mplogin/is_send_password_to_customer')){
				$customer->sendPasswordReminderEmail();
			}
			$nextUrl = Mage::helper('sociallogin')->getEditUrl();
			Mage::getSingleton('core/session')->addNotice('Please enter your contact detail.');			
			die("<script>window.close();window.opener.location = '$nextUrl';</script>");
		}
		else{
			$customer = $this->getCustomer($customerId);									
			Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);				
			die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
		}		
    }
	
	/**
	* return customer_id in table authorlogin
	**/
	public function getCustomerId($mpId){
		$user = Mage::getModel('sociallogin/authorlogin')->getCollection()
						->addFieldToFilter('author_id', $mpId)
						->getFirstItem();
		if($user)
			return $user->getCustomerId();
		else
			return NULL;
	}
	
	/**
	* input: 
	*	@mpId
	*	@customerid	
	**/
	public function setAuthorCustomer($mpId, $customerId){
		$mod = Mage::getModel('sociallogin/authorlogin');
		$mod->setData('author_id', $mpId);		
		$mod->setData('customer_id', $customerId);		
		$mod->save();		
		return ;
	}
	
	/**
	* return @collectin in model customer
	**/
	public function getCustomer ($id){
		$collection = Mage::getModel('customer/customer')->load($id);
		return $collection;
	}
}
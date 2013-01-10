<?php
class Magestore_Sociallogin_FqloginController extends Mage_Core_Controller_Front_Action{

	/**
	* getToken and call profile user FoursQuare
	**/
    public function loginAction() {            		
		if(!Mage::helper('magenotification')->checkLicenseKeyFrontController($this)){return;}
		$isAuth = $this->getRequest()->getParam('auth');
		$foursquare = Mage::getModel('sociallogin/fqlogin')->newFoursquare();
		$code = $_REQUEST['code'];	
		$date = date('Y-m-d');
		$date = str_replace('-', '', $date);
		$oauth = $foursquare->GetToken($code);

		if(!$oauth){
			echo("<script>window.close()</script>");
			return ;
		}
		$url = 'https://api.foursquare.com/v2/users/self?oauth_token='.$oauth.'&v='.$date;
		try{
			$json = Mage::helper('sociallogin')->getResponseBody($url);
		}catch( Exception $e){
			$coreSession = Mage::getSingleton('core/session');
			$coreSession->addError('Login fail!');			
            die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
		}		
		$string = $foursquare->getResponseFromJsonString($json);		
		$first_name = $string->user->firstName;
		$last_name = $string->user->lastName;
		$email = $string->user->contact->email;						
		if ($isAuth && $oauth){
			$data =  array('firstname'=>$first_name, 'lastname'=>$last_name, 'email'=>$email);
			$customer = Mage::helper('sociallogin')->getCustomerByEmail($data['email']);
			if(!$customer || !$customer->getId()){
				$customer = Mage::helper('sociallogin')->createCustomer($data);
				if(Mage::getStoreConfig('sociallogin/fqlogin/is_send_password_to_customer')){
					$customer->sendPasswordReminderEmail();
				}				
			}
			Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
			die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
    	}
	}
}
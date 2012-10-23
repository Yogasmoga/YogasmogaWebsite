<?php
class Magestore_Sociallogin_FbloginController extends Mage_Core_Controller_Front_Action{

    public function loginAction() {
		if(!Mage::helper('magenotification')->checkLicenseKeyFrontController($this)){return;}
		$isAuth = $this->getRequest()->getParam('auth');
		$facebook = Mage::getModel('sociallogin/fblogin')->newFacebook();
		$userId = $facebook->getUser();
		
		if($isAuth && !$userId && $this->getRequest()->getParam('error_reason') == 'user_denied'){
			echo("<script>window.close()</script>");
		}elseif ($isAuth && !$userId){
			$loginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
			echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
			exit;
		}
 		$user = Mage::getModel('sociallogin/fblogin')->getFbUser();
 
		if ($isAuth && $user){
			$data =  array('firstname'=>$user['first_name'], 'lastname'=>$user['last_name'], 'email'=>$user['email']);
			$customer = Mage::helper('sociallogin')->getCustomerByEmail($data['email']);
			if(!$customer || !$customer->getId()){
				$customer = Mage::helper('sociallogin')->createCustomer($data);
				
			}
			Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
			die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
    	}
	}
	
}
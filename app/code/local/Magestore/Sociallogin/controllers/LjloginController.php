<?php
class Magestore_Sociallogin_LjloginController extends Mage_Core_Controller_Front_Action{
   
   public function loginAction() {     
		$identity = $this->getRequest()->getPost('identity');
		Mage::getSingleton('core/session')->setData('identity',$identity);
		$my = Mage::getModel('sociallogin/ljlogin')->newMy();
		/*$my->required = array(
        'namePerson/first',
        'namePerson/last',
        'namePerson/friendly',
        'contact/email',
		'namePerson' 
        );*/
		Mage::getSingleton('core/session')->setData('identity',$identity);
		$userId = $my->mode;       	
		$coreSession = Mage::getSingleton('core/session');
		if(!$userId){
            $my = Mage::getModel('sociallogin/ljlogin')->setLjIdlogin($my,$identity);
			try{
				$url = $my->authUrl();
			}catch(Exception $e){
				$coreSession->addError('Username not exacted');			
                die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
			}
			echo "<script type='text/javascript'>top.location.href = '$url';</script>";
			exit;
		}
        else{                        
            if (!$my->validate()){ 
               $my_session = Mage::getModel('sociallogin/ljlogin')->setLjIdlogin($my,$identity);
                try{
				$url = $my->authUrl();
			}catch(Exception $e){
				$coreSession->addError('Username not exacted');			
                die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
			}
                echo "<script type='text/javascript'>top.location.href = '$url';</script>";
                exit;
            }
            else{       			
               // $user_info = $my->getAttributes();
				$user_info = $my->data;
                if(count($user_info)){
					$user = array();
					$identity = $user_info['openid_identity'];
					$length = strlen($identity);
					$httpLen = strlen("http://");
					$userAccount = substr($identity,$httpLen,$length-1-$httpLen);
					$userArray = explode( '.', $userAccount,2);
					$firstname = $userArray[0];
					$lastname ="";
					$email = $firtname."@".$userArray[1];
					$user['firstname'] = $firstname;
					$user['lastname'] = $lastname;
					$user['email'] = $email;
					$authorId = $email;
						
					$customer_id = Mage::getModel('sociallogin/authorlogin')->checkCustomer($authorId);
					if($customer_id){
						$customer = Mage::getModel('customer/customer')->load($customer_id);
						Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
						//$customer = Mage::helper('sociallogin')->getCustomerByEmail($email);
						die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
					}
					if(!$customer_id){
						$customer = Mage::helper('sociallogin')->getCustomerByEmail($email);
						if(!$customer || !$customer->getId()){
							$customer = Mage::helper('sociallogin')->createCustomer($user);
						}
						Mage::getModel('sociallogin/authorlogin')->addCustomer($authorId);
						if (Mage::getStoreConfig('sociallogin/ljlogin/is_send_password_to_customer')){
							$customer->sendPasswordReminderEmail();
						}
						Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
						$nextUrl = Mage::helper('sociallogin')->getEditUrl();						
						die("<script>window.close();window.opener.location = '$nextUrl';</script>");
					}
                }                
                else{
                   $coreSession->addError('User has not shared information so login fail!');			
                   die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::getBaseUrl()."\"} window.close();</script>");
                }
            }           
        }
    }
	
	/**
	* return template au_wp.phtml
	**/
    public function setBlockAction()
    {             
        /*$template =  $this->getLayout()->createBlock('sociallogin/ljlogin')
                ->setTemplate('sociallogin/au_lj.phtml')->toHtml();
        echo $template;*/
		$this->loadLayout();
		$this->renderLayout();
    }
}
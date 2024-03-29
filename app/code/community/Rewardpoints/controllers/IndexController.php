<?php
/**
 * J2T RewardsPoint2
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@j2t-design.com so we can send you a copy immediately.
 *
 * @category   Magento extension
 * @package    RewardsPoint2
 * @copyright  Copyright (c) 2009 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Rewardpoints_IndexController extends Mage_Core_Controller_Front_Action
{
    
    public function indexAction()
    {
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            $session         = Mage::getSingleton('core/session');
            $emails           = $this->getRequest()->getPost('email'); //trim((string) $this->getRequest()->getPost('email'));
            $names            = $this->getRequest()->getPost('name'); //trim((string) $this->getRequest()->getPost('name'));

            
            $customerSession = Mage::getSingleton('customer/session');
            //$errors = array();
            try {
                foreach ($emails as $key_email => $email){
                    $name = trim((string) $names[$key_email]);
                    $email = trim((string) $email);
                    
                    ///////////////////////////////////////////
                    
                    $no_errors = true;
                    if (!Zend_Validate::is($email, 'EmailAddress')) {
                        //Mage::throwException($this->__('Please enter a valid email address.'));
                        //$errors[] = $this->__('Wrong email address (%s).', $email);
                        $session->addError($this->__('Wrong email address (%s).', $email));
                        $no_errors = false;
                    }
                    if ($name == ''){
                        //Mage::throwException($this->__('Please enter your friend name.'));
                        //$errors[] = $this->__('Friend name is required for (%s) on line %s.', $email, ($key_email+1));
                        $session->addError($this->__('Friend name is required for email: %s on line %s.', $email, ($key_email+1)));
                        $no_errors = false;
                    }
                    
                    if ($no_errors){
                        $referralModel = Mage::getModel('rewardpoints/referral');

                        $customer = Mage::getModel('customer/customer')
                                        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                                        ->loadByEmail($email);

                        if ($referralModel->isSubscribed($email) || $customer->getEmail() == $email) {
                            //Mage::throwException($this->__('Email %s has been already submitted.', $email));
                            $session->addError($this->__('Email %s has been already submitted.', $email));
                        } else {
                            if ($referralModel->subscribe($customerSession->getCustomer(), $email, $name)) {
                                $session->addSuccess($this->__('Email %s was successfully invited.', $email));
                            } else {
                                $session->addError($this->__('There was a problem with the invitation email %s.', $email));
                            }
                        }
                    }
                    
                    ///////////////////////////////////////////
                }
                
            }
            catch (Mage_Core_Exception $e) {
                $session->addException($e, $this->__('%s', $e->getMessage()));
            }
            catch (Exception $e) {
                print_r($e);
                die;
                $session->addException($e, $this->__('There was a problem with the invitation.'));
            }
        }

        /*$handles = array('default');
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $handles[] = 'customer_account';
        }
        $this->loadLayout($handles);
        $this->renderLayout();*/

        $this->loadLayout();
        $this->renderLayout();


    }
    

    public function referralAction()
    {
        $this->indexAction();
    }

    public function pointsAction()
    {
        $this->indexAction();
    }


    public function goReferralAction(){
        $userId = (int) $this->getRequest()->getParam('referrer');
        Mage::getSingleton('rewardpoints/session')->setReferralUser($userId);
        //Mage::getSingleton('rewardpoints/session')->getReferralUser()
        //$url = Mage::getUrl();
        //$this->getResponse()->setRedirect($url);
        
        if ($url_redirection = Mage::getStoreConfig('rewardpoints/registration/referral_redirection', Mage::app()->getStore()->getId())){

            //Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::helper('core/url')->getHomeUrl()."?utm_source=refer-a-friend&utm_medium=email&utm_campaign=refer-a-friend");
            Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('',array('_secure'=>true))."?utm_source=refer-a-friend&utm_medium=email&utm_campaign=refer-a-friend");


              //$this->_redirect($url_redirection,$referUrl);
            //$this->_redirect("/?utm_source=refer-a-friend&utm_medium=email&utm_campaign=refer-a-friend");
        } else {
            $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_HOME_PAGE);
            if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
                $this->_forward('defaultIndex');
            }
        }
        
    }

    public function removequotationAction(){
	 Mage::getSingleton('core/session')->setCPmsg(''); 
        Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
        Mage::helper('rewardpoints/event')->setCreditPoints(0);
        Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity(NULL)
                ->setRewardpointsDescription(NULL)
                ->setBaseRewardpoints(NULL)
                ->setRewardpoints(NULL)
                ->save();
        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = empty($defaultUrl) ? Mage::getBaseUrl() : $defaultUrl;
        }

        $myValue=Mage::getSingleton('core/session')->getSmogiValue();
        if($myValue == 'smogi-promotions')
        {
            $refererUrl = $refererUrl.'#smogi-promotions';
        }
        else{
            $refererUrl = $refererUrl.'#promotions';
        }
        $this->getResponse()->setRedirect($refererUrl);
    }

    public function quotationAction(){
		 $response = array(
            "status" => "error",
            "error"  => "",
            "success_message" => ""
        );
        //check do not apply smogi bucks for only accesories in cart
		   $miniitems = Mage::getSingleton('checkout/session')->getQuote()->getAllItems();
        if(isset($miniitems))
        {
            $excludecats = Mage::getModel('core/variable')->loadByCode('nosmogicategories')->getValue('plain');
            $excludecats = explode(",", $excludecats);
            $flag = 0;
            foreach($miniitems as $mitem)
            {
                $mitemProduct = Mage::getModel('catalog/product')->loadByAttribute('sku', $mitem['sku']);
                $cids = $mitemProduct->getCategoryIds();
				//echo "<pre>";
                //print_r($excludecats);
                $flag = 0;
                foreach($excludecats as $key=>$val)
                {
                   if (in_array($val, $cids)) { 
				   $flag = 1;
				   }
				  
                }
                if($flag == 0)break;          
            }

            // promotion check
/*
            if($flag==0){

                foreach($miniitems as $mitem)
                {

                    $price = $mitem['price'];

                    if(is_null($mitem['parent_item_id'])){

                        if(intval($price)==0){

                            Mage::getSingleton("core/session")->addError("SMOGI Bucks cannot be used on Promotions");
                            $refererUrl = $this->_getRefererUrl();
                            $this->getResponse()->setRedirect($refererUrl);
                            return;
                        }
                    }
                }

            }
*/
            if($flag == 1)
            {
              
			   Mage::getSingleton("core/session")->addError("SMOGI Bucks can not be applied to One 2 Many, Accessories or other promotions.");

			   //$response['error'] = "SMOGI Bucks cannot be used Toward Accessories / ONE 2 MANY Items";
              //  echo json_encode($response);
               $refererUrl = $this->_getRefererUrl();
            }

            /********** smogi bucks should not be applied when discount is there ***************/
            $data = Mage::getSingleton('checkout/cart')->getQuote()->getAllVisibleItems();
            if(isset($data)) {
                foreach ($data as $item) {
                    if (isset($item['discount_amount']) && floatval($item['discount_amount'] > 0)) {
                        Mage::getSingleton("core/session")->addError("SMOGI Bucks can not be applied to One 2 Many, Accessories or other promotions.");
						
                        $refererUrl = $this->_getRefererUrl();
                        $this->getResponse()->setRedirect($refererUrl);
                        $flag = 1;
                        return;
                    }
                }
            }
            /********** smogi bucks should not be applied when discount is there ***************/
        }
        
        $session = Mage::getSingleton('core/session');
        $points_value = $this->getRequest()->getPost('points_to_be_used');
		//echo $flag ;
		//exit;
		Mage::getSingleton('core/session')->setCPmsg($points_value);
		
        if (Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId())){
            if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId()) < $points_value){
                $points_max = (int)Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId());
                $session->addError($this->__('You tried to use %s loyalty points, but you can use a maximum of %s points per shopping cart.', $points_value, $points_max));
                $points_value = $points_max;
            }
        }
        $quote_id = Mage::helper('checkout/cart')->getCart()->getQuote()->getId();

        Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
        Mage::getSingleton('rewardpoints/session')->setShippingChecked(0);
        Mage::helper('rewardpoints/event')->setCreditPoints($points_value);
        Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity($points_value)
                ->save();

        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = empty($defaultUrl) ? Mage::getBaseUrl() : $defaultUrl;
        }
        $myValue=Mage::getSingleton('core/session')->getSmogiValue();
        if($myValue == 'smogi-promotions')
        {
            $refererUrl = $refererUrl;
        }
        
        $this->getResponse()->setRedirect($refererUrl);
    }

    public function preDispatch()
    {
        
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $actions_array = array('referral', 'points');
        if (in_array($action, $actions_array)){
            $loginUrl = Mage::helper('customer')->getLoginUrl();

            if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            }
        }
    }
    
}
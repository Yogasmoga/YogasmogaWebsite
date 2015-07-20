<?php
include_once("Mage/Customer/controllers/AccountController.php");
class Bluethink_Loadregistration_AccountController extends Mage_Customer_AccountController
{
 public function createPostAction() {
/** @var $session Mage_Customer_Model_Session */
    	$params = $this->getRequest()->getParams();
    //	echo $params['isAjax'].'<pre>'; var_dump($params);die;
    	if($params['isAjax']== 1){
			$response=array();
        $session = $this->_getSession();
        if ($session->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session->setEscapeMessages(true); // prevent XSS injection in user input
        
  
            
        //$customer = $this->_getCustomer();
          $customer = Mage::getModel("customer/customer");
        $websiteId = Mage::app()->getWebsite()->getId();
        $store = Mage::app()->getStore();
           $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
           $customer->loadByEmail($params['email']);
            if($customer->getId()) {
				 $response['msg']=  'Email already exists';
              $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		     return;             
                
			}
     
        $customer->setWebsiteId($websiteId)
            ->setStore($store)
            ->setFirstname($params['firstname'])
            ->setLastname($params['lastname'])
            ->setEmail($params['email'])          
            ->setPassword($params['password1']);            
            
             // Try create customer
        try {
            $customer->save();
            $customer->setConfirmation(null);
            $customer->save();
            $response['msg']='success';
            $customAddress = Mage::getModel('customer/address')            
                       ->setCustomerId($customer->getId())
                        ->setTelephone($params['mobile']);
                $customAddress->save();        
            $storeId = $customer->getSendemailStoreId();
            $customer->sendNewAccountEmail('registered', '', $storeId);
            
           Mage::getSingleton('customer/session')->loginById($customer->getId());
  
              
           $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		     return;            
             } catch (Exception $e) {
				 $response['msg']='error';
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
		     return;
                }                  
        }
        else{
			return parent::createPostAction();
		}
}

}

<?php 
class Mycustommodules_Mynewsletter_MysubscriberController extends Mage_Core_Controller_Front_Action
{
    public function addAction(){
        //echo "Add new subscriber from custom module<br/>";
        //print_r($this->getRequest()->getParams());
//        echo $this->getRequest()->getPost('email');
//        echo "called";
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            //if(true){
            //echo "got in";
            $session            = Mage::getSingleton('core/session');
            $customerSession    = Mage::getSingleton('customer/session');
            $email              = (string) $this->getRequest()->getPost('email');
            
            //echo " Email = ".$this->getRequest()->getPost('email');
            
            try {
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    $arr['status'] = "0";
                    $arr['message'] = "Doesn't look like that's a valid Email Address";
                    echo json_encode($arr);
                    //echo "Please enter a valid email address";
                    return;
                    //Mage::throwException($this->__('Please enter a valid email address.'));
                }

                if (Mage::getStoreConfig(Mage_Newsletter_Model_Subscriber::XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG) != 1 && 
                    !$customerSession->isLoggedIn()) {
                        $arr['status'] = "0";
                        $arr['message'] = "Sorry, but administrator denied subscription for guests";
                        echo json_encode($arr);
                        //echo "Sorry, but administrator denied subscription for guests";
                        return;
                    //Mage::throwException($this->__('Sorry, but administrator denied subscription for guests. Please <a href="%s">register</a>.', Mage::helper('customer')->getRegisterUrl()));
                }

                $ownerId = Mage::getModel('customer/customer')
                        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                        ->loadByEmail($email)
                        ->getId();
                if ($ownerId !== null && $ownerId != $customerSession->getId()) {
                    $arr['status'] = "0";
                    $arr['message'] = "This email address is already assigned to another user";
                    echo json_encode($arr);
                    //echo "This email address is already assigned to another user";
                    return;
                    //Mage::throwException($this->__('This email address is already assigned to another user.'));
                }

                $status = Mage::getModel('newsletter/subscriber')->subscribe($email);
                if ($status == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                    $arr['status'] = "1";
                    $arr['message'] = "Confirmation request has been sent";
                    echo json_encode($arr);
                    //echo "Confirmation request has been sent";
                    return;
                    //$session->addSuccess($this->__('Confirmation request has been sent.'));
                }
                else {
                    $arr['status'] = "1";
                    $arr['message'] = "Thank you for your subscription";
                    echo json_encode($arr);
                    //echo "Thank you for your subscription";
                    return;
                    //$session->addSuccess($this->__('Thank you for your subscription.'));
                }
            }
            catch (Mage_Core_Exception $e) {
                $arr['status'] = "0";
                $arr['message'] = "There was a problem with the subscription";
                echo json_encode($arr);
                //echo "There was a problem with the subscription: ".$e->getMessage();
                return;                
                //$session->addException($e, $this->__('There was a problem with the subscription: %s', $e->getMessage()));
            }
            catch (Exception $e) {
                $arr['status'] = "0";
                $arr['message'] = "There was a problem with the subscription";
                echo json_encode($arr);
                //echo "There was a problem with the subscription";
                return;
                //$session->addException($e, $this->__('There was a problem with the subscription.'));
            }
        }
        //$this->_redirectReferer();
    }
}
?>
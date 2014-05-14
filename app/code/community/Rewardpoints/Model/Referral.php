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
class Rewardpoints_Model_Referral extends Mage_Core_Model_Abstract
{
    
    const XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE       = 'rewardpoints/registration/subscription_email_template';
    const XML_PATH_SUBSCRIPTION_EMAIL_IDENTITY       = 'rewardpoints/registration/subscription_email_identity';

    const XML_PATH_CONFIRMATION_EMAIL_TEMPLATE       = 'rewardpoints/registration/confirmation_email_template';
    const XML_PATH_CONFIRMATION_EMAIL_IDENTITY       = 'rewardpoints/registration/confirmation_email_identity';
    


    public function _construct()
    {
        parent::_construct();
        $this->_init('rewardpoints/referral');
    }

    public function getInvites($id){
        return $this->getCollection()->addClientFilter($id);
    }

    public function loadByEmail($customerEmail)
    {
        $this->addData($this->getResource()->loadByEmail($customerEmail));
        return $this;
    }
    
    //J2T Check referral
    public function loadByChildId($child_id)
    {
        $this->addData($this->getResource()->loadByChildId($child_id));
        return $this;
    }

    public function subscribe(Mage_Customer_Model_Customer $parent, $email, $name)
    {
        $this->setRewardpointsReferralParentId($parent->getId())
             ->setRewardpointsReferralEmail($email)
             ->setRewardpointsReferralName($name);
             
        if($this->sendSubscription($parent, $email, $name))
        {
            if($this->save())
                return true;
            else
                return false;
        }
        else
            return false;
        //return $this->save() && $this->sendSubscription($parent, $email, $name);
    }

    public function isSubscribed($email)
    {
        $collection = $this->getCollection()->addEmailFilter($email);
        return $collection->count() ? true : false;
    }

    public function isConfirmed($email)
    {
        $collection = $this->getCollection()->addFlagFilter(0);
        $collection->addEmailFilter($email);
        return $collection->count() ? false : true;
    }

    public function sendSubscription(Mage_Customer_Model_Customer $parent, $destination, $destination_name)
    {
        $this->setRewardpointsReferralParentId($parent->getId())
             ->setRewardpointsReferralEmail($destination)
             ->setRewardpointsReferralName($destination_name);
        
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        
        //$template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, $this->getStoreId());

        $email = Mage::getModel('core/email_template');
        /* @var $email Mage_Core_Model_Email_Template */
        //$email->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()));


        $template = Mage::getStoreConfig(self::XML_PATH_SUBSCRIPTION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        $recipient = array(
            'email' => $destination,
            'name'  => $destination_name
        );

        $sender  = array(
            //'name' => strip_tags($parent->getFirstname().' '.$parent->getLastname()),
            'name' => 'YOGASMOGA',
            //'email' => strip_tags($parent->getEmail())
            'email' => 'hello@yogasmoga.com'
        );

        $email->setDesignConfig(array('area'=>'frontend', 'store'=> Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template,
                    $sender,
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'parent'        => $parent,
                        'referral'      => $this,
                        'store_name'    => Mage::getModel('core/store')->load(Mage::app()->getStore()->getCode())->getName(),
                        'referral_url'  => Mage::getUrl('rewardpoints/index/goReferral', array("referrer" => $parent->getId()))
                        //'comment' => "This is test comment for testing purpose"
                    )
                );

        $translate->setTranslateInline(true);

        return $email->getSentSuccess();
    }

    public function sendConfirmation(Mage_Customer_Model_Customer $parent, Mage_Customer_Model_Customer $child, $destination)
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $readresult=$write->query("SELECT COUNT(rewardpoints_referral_email) as cnt, rewardpoints_referral_parent_id as Id,CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_parent_id AND attribute_id=7)) AS 'Name' FROM rewardpoints_referral rr WHERE rewardpoints_referral_status=1 AND rewardpoints_referral_parent_id=(SELECT entity_id FROM customer_entity ce WHERE ce.email='".$parent->getEmail()."')");
        $successreferalcount = 0;
        $customerId = 0;
        $customername = "";
        while ($row = $readresult->fetch() ) {
            $successreferalcount = $row['cnt'];
            $customerId = $row['Id'];
            $customername = $row['Name'];
        }
        if($successreferalcount >= 2)
        {
            try {
                $storeObj = Mage::getModel('core/store')->load(Mage::app()->getStore()->getId());
                $customerEmailId = $parent->getEmail();
                $customerFName = $parent->getFirstname();
                $customerLName = $parent->getLastname();
                        
    
                //load the custom template to the email  
                $emailTemplate = Mage::getModel('core/email_template')
                        ->loadDefault('custom_notification_template1');
               
                // it depends on the template variables
                $emailTemplateVariables = array();
                
                
                
                $emailTemplateVariables['customername'] = $customername;
                $emailTemplateVariables['customeremail'] = $customerEmailId;
                $emailTemplateVariables['referralcount'] = $successreferalcount;
                
                $readresult=$write->query("SELECT CONCAT((SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_child_id AND attribute_id=5),' ',(SELECT VALUE FROM customer_entity_varchar WHERE entity_id=rr.rewardpoints_referral_child_id AND attribute_id=7)) AS 'Name',rewardpoints_referral_email AS 'Email' FROM rewardpoints_referral rr WHERE rr.rewardpoints_referral_parent_id=".$customerId." AND rr.rewardpoints_referral_status=1");
                $tableoutput = "<table border='1'><thead><tr><th>Name</th><th>Email</th></tr></thead><tbody>";
                while ($row = $readresult->fetch() ) {
                    $tableoutput .= "<tr><td>".$row['Name']."</td><td>".$row['Email']."</td></tr>";
                }
                $tableoutput .= "</tbody></table>";
                
                $emailTemplateVariables['referraldetails'] = $tableoutput;
                //$emailTemplateVariables['store'] = $storeObj;
                //$emailTemplateVariables['payment_html'] = $method;
           
    
                $emailTemplate->setSenderName('Referral Notification');
                $emailTemplate->setSenderEmail('report@yogasmoga.com');
                $emailTemplate->setType('html');
                $emailTemplate->setTemplateSubject($customername." (".$customerEmailId.") got ".$successreferalcount." successfull referrals");
                $emailTemplate->send("oksana.gervas@yogasmoga.com", "Oksana Gervas", $emailTemplateVariables);
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
                //return $errorMessage;
                Mage::log($errorMessage,null,'notification.log');
            }      
        }
        
        
        
        
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $email = Mage::getModel('core/email_template');
        /* @var $email Mage_Core_Model_Email_Template */        

        $template = Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());
        $recipient = array(
            'email' => $destination,
            'name'  => $destination
        );

        $sender  = Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_EMAIL_IDENTITY);

        $email->setDesignConfig(array('area'=>'frontend', 'store'=>Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template,
                    $sender,
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'parent'   => $parent,
                        'child'   => $child,
                        'referral' => $this,
                        'store_name' => Mage::getModel('core/store')->load(Mage::app()->getStore()->getCode())->getName()
                    )
                );

        $translate->setTranslateInline(true);
        return $email->getSentSuccess();
    }

}
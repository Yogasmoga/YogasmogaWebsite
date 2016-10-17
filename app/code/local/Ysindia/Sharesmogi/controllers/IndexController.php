<?php

/*
 * This is a controller for share smogi module.
 * Created by Fahim Khan (Sr. Magento Developer).
 */
class Ysindia_Sharesmogi_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		/*
    	if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/login',array('_secure'=>true)));
		}*/
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/sharesmogi?id=15 
    	 *  or
    	 * http://site.com/sharesmogi/id/15 	
    	 */
    	/* 
		$sharesmogi_id = $this->getRequest()->getParam('id');

  		if($sharesmogi_id != null && $sharesmogi_id != '')	{
			$sharesmogi = Mage::getModel('sharesmogi/sharesmogi')->load($sharesmogi_id)->getData();
		} else {
			$sharesmogi = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($sharesmogi == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$sharesmogiTable = $resource->getTableName('sharesmogi');
			
			$select = $read->select()
			   ->from($sharesmogiTable,array('sharesmogi_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$sharesmogi = $read->fetchRow($select);
		}
		Mage::register('sharesmogi', $sharesmogi);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function shareAction(){

		$response = array(
			"status" => 'error',
			"error" => '',
			"success_message" => ''
		);

	if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			//Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/login',array('_secure'=>true)));
			$response['status'] = "error";
			$response['error'] = "Please login first.";
			echo json_encode($response);
			return;
		}

		$childEmail = Mage::app()->getRequest()->getParam('email');
		$customerModel = Mage::getModel('customer/customer');

		$customerModel->setWebsiteId(Mage::app()->getWebsite()->getId());
		$customerModel->loadByEmail($childEmail);

		if($customerModel->getId())
		{
			$response['status'] = "error";
			$response['error'] = "This email is already registered. Please try another.";
			echo json_encode($response);
			return;
		}


		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$parentId = $customer->getId();
		$parentEmail = $customer->getEmail();

		$modal =  Mage::getModel('sharesmogi/sharesmogi');
		$childPoints = Mage::getStoreConfig('tab1/general/smogi', Mage::app()->getStore()->getId());
		$smogiChildPoints = 0;
		$smogiExistEmail = false;
		$sharesmogiCollection = $modal->getCollection();
		foreach($sharesmogiCollection as $smogi){
			if($smogi->getChildEmail() == $childEmail){
				$smogiExistEmail = true;
			}
		}
		if($childEmail){
				if($childEmail == $parentEmail  || $smogiExistEmail){
					$response['status'] = "error";
					$response['error'] = "Sorry! You have already invited. Please, try another email.";
					echo json_encode($response);
					return;
				}
				else{
					$reward_model = Mage::getModel('rewardpoints/stats');
					$points = $reward_model->getPointsCurrent($parentId, Mage::app()->getStore()->getId());

						try {

							$modal->setParentId($parentId);
							$modal->setParentEmail($parentEmail);
							$modal->setChildEmail($childEmail);
							$modal->save();

							// Send email.
							$templateId = "share_smogi_bucks";
							$emailTemplate = Mage::getModel('core/email_template')->loadByCode($templateId);
							$vars = array('email' => $childEmail);

							$emailTemplate->getProcessedTemplate($vars);
							$emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
							$emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));

								if (!empty($childEmail)) {
									$emailTemplate->send($childEmail, $vars);
									$response['status'] = "success";
									$response['success_message'] = "Congratulation! You have Shared your 25 smogi bucks.";
									echo json_encode($response);
									return;
								}
						}
							catch (Exception $e) {
								$response['status'] = "error";
								$response['error'] = "Unable to submit your request. Please, try later.";
								echo json_encode($response);
								return;
						}
					}
			}
	}
}
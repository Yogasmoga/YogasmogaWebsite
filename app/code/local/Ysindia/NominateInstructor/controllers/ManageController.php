<?php
class Ysindia_NominateInstructor_ManageController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
		
		      $postData = $this->getRequest()->getPost();
			//echo '<pre/>'; print_r($postData); die;
		
                $Model = Mage::getModel('nominateinstructor/nominateinstructor');
               
                $Model->setId($this->getRequest()->getParam('id'))
                    ->setYourFirstName($postData['your_first_name'])
                    ->setYourLastName($postData['your_last_name'])
                    ->setYourEmail($postData['your_email'])
					->setYourGender($postData['your_gender'])
					->setInstructorFirstName($postData['instructor_first_name'])
					->setInstructorLastName($postData['instructor_last_name'])
					->setInstructorEmail($postData['instructor_email'])
					->setContent($postData['content'])
                    ->save();
					
					Mage::getSingleton('core/session')->addSuccess('Item was successfully saved');
					//$this->_redirect('*/*/');
					
				echo 'Thankyou!';	
	}
}
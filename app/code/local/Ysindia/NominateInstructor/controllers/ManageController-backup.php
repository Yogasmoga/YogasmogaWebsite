<?php
class Ysindia_NominateInstructor_ManageController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/nominateinstructor?id=15 
    	 *  or
    	 * http://site.com/nominateinstructor/id/15 	
    	 */
    	/* 
		$nominateinstructor_id = $this->getRequest()->getParam('id');

  		if($nominateinstructor_id != null && $nominateinstructor_id != '')	{
			$nominateinstructor = Mage::getModel('nominateinstructor/nominateinstructor')->load($nominateinstructor_id)->getData();
		} else {
			$nominateinstructor = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($nominateinstructor == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$nominateinstructorTable = $resource->getTableName('nominateinstructor');
			
			$select = $read->select()
			   ->from($nominateinstructorTable,array('nominateinstructor_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$nominateinstructor = $read->fetchRow($select);
		}
		Mage::register('nominateinstructor', $nominateinstructor);
		*/

			
		//$this->loadLayout();     
		echo '<pre/>';
		print_r($this->getRequest()->getPost());
		die;
		//$this->renderLayout();
    }
}
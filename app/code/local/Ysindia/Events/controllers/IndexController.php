<?php
class Ysindia_Events_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/events?id=15 
    	 *  or
    	 * http://site.com/events/id/15 	
    	 */
    	/* 
		$events_id = $this->getRequest()->getParam('id');

  		if($events_id != null && $events_id != '')	{
			$events = Mage::getModel('events/events')->load($events_id)->getData();
		} else {
			$events = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($events == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$eventsTable = $resource->getTableName('events');
			
			$select = $read->select()
			   ->from($eventsTable,array('events_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$events = $read->fetchRow($select);
		}
		Mage::register('events', $events);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
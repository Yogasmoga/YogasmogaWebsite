<?php

class Ysindia_Disableproducts_Model_Observer
{
    public function catalogProductViewPostdispatch($observer)
    {
        
		$controller = $observer->getEvent()->getControllerAction();
		$product = Mage::getModel('catalog/product')->load($controller->getRequest()->getParam('id'));

        if($product->getStatus()!=Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
		{
            Mage::app()->getFrontController()->getResponse()->setRedirect('/design-elements');
        }
    }
}
<?php
/**
 * Mageplace Magento-SugarCRM Bridge
 *
 * @category    Belitsoft_Sugarcrm
 * @package     Belitsoft_Sugarcrm
 * @copyright   Copyright (c) 2011 Mageplace. (http://www.mageplace.com)
 * @license     http://www.mageplace.com/disclaimer.html
 */

class Belitsoft_Sugarcrm_Model_Observer
{
	function processSaveCustomerBefore($observer)
	{
		$customer = $observer->getEvent()->getCustomer();
		if (($customer instanceof Mage_Customer_Model_Customer)) {
			$this->_isNewCustomer($customer, true);
		}

		return $this;
	}

	function processSaveCustomer($observer)
	{
		try {
			$customer = $observer->getEvent()->getCustomer();
			if (($customer instanceof Mage_Customer_Model_Customer)) {
				$isNew = $this->_isNewCustomer($customer);
				$customer->setIsCustomerNew($isNew);
				$operation = $isNew ? Belitsoft_Sugarcrm_Model_Connection::OPERATION_INSERT : Belitsoft_Sugarcrm_Model_Connection::OPERATION_UPDATE;
				
				Mage::getModel('sugarcrm/connection')->synchCustomer($customer, $operation);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			Mage::getModel('sugarcrm/error')->addErrorParams(array('operation'=>$operation), Belitsoft_Sugarcrm_Model_Error::TYPE_CUSTOMER);
			Mage::getModel('sugarcrm/error')->addError(Belitsoft_Sugarcrm_Model_Error::TYPE_CUSTOMER, __FUNCTION__, $customer, $e);
		}

		return $this;
	}

	function processSaveCustomerAddress($observer)
	{
		if(Mage::app()->getStore()->isAdmin()) {
			return $this;
		}

		try {
			$customer = null;
			if ($observer->getEvent()->getCustomerAddress()->getCustomerId()) {
				$customer = Mage::getModel('customer/customer')
					->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
				$customer->load($observer->getEvent()->getCustomerAddress()->getCustomerId());
				$customer->getAddresses();
			}
			if (($customer instanceof Mage_Customer_Model_Customer)) {
				Mage::getModel('sugarcrm/connection')->synchCustomer($customer);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			Mage::getModel('sugarcrm/error')->addError(Belitsoft_Sugarcrm_Model_Error::TYPE_CUSTOMER, __FUNCTION__, $customer, $e);
		}

		return $this;
	}

	function processDeleteBeforeCustomer($observer)
	{
		try {
			$customer = $observer->getEvent()->getCustomer();
			if (($customer instanceof Mage_Customer_Model_Customer)) {
				Mage::getModel('sugarcrm/connection')->setSynchDataBeforeDelete($customer);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			Mage::getModel('sugarcrm/error')->addErrorParams(array('entity_id'=>$customer->getId()), Belitsoft_Sugarcrm_Model_Error::TYPE_CUSTOMER);
		}

		return $this;
	}

	function processDeleteAfterCustomer($observer)
	{
		try {
			$customer = $observer->getEvent()->getCustomer();
			if (($customer instanceof Mage_Customer_Model_Customer)) {
				Mage::getModel('sugarcrm/connection')->synchCustomer($customer, Belitsoft_Sugarcrm_Model_Connection::OPERATION_DELETE);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			Mage::getModel('sugarcrm/error')->addError(Belitsoft_Sugarcrm_Model_Error::TYPE_CUSTOMER, __FUNCTION__, $customer, $e);
		}

		return $this;
	}

	function processSalesOrderSaveAfter($observer)
	{
		if(!Mage::getModel('sugarcrm/config')->isEnabledUserOrdersSynch()) {
			return $this;
		}

		try {
			$order = $observer->getEvent()->getOrder();
			if ($order instanceof Mage_Sales_Model_Order) {
				$order->setOrderObjectName(Belitsoft_Sugarcrm_Model_Synchmap::ORDER_MODEL);
				Mage::getModel('sugarcrm/connection')->synchOrder($order);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			Mage::getModel('sugarcrm/error')->addError(Belitsoft_Sugarcrm_Model_Error::TYPE_ORDER, __FUNCTION__, $order, $e);
		}

		return $this;
	}

	function processSalesOrderDeleteAfter($observer)
	{
		if(!Mage::getModel('sugarcrm/config')->isEnabledUserOrdersSynch()) {
			return $this;
		}

		try {
			$order = $observer->getEvent()->getOrder();
			if ($order instanceof Mage_Sales_Model_Order) {
				$order->setOrderObjectName(Belitsoft_Sugarcrm_Model_Synchmap::ORDER_MODEL);
				Mage::getModel('sugarcrm/connection')->synchOrder($order, Belitsoft_Sugarcrm_Model_Connection::OPERATION_DELETE);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			Mage::getModel('sugarcrm/error')->addError(Belitsoft_Sugarcrm_Model_Error::TYPE_ORDER, __FUNCTION__, $order, $e);
		}

		return $this;
	}

	function processSalesQuoteMergeAfter($observer)
	{
		if(!Mage::getModel('sugarcrm/config')->isEnabledUserOrdersSynch()
			|| (!Mage::helper('sugarcrm')->isCheckoutSynchEnabled()
				&& !Mage::helper('sugarcrm')->isCartSynchEnabled()))
		{
			return $this;
		}

		try {
			$quoteItem = $observer->getEvent()->getQuote();
			$sourceItem = $observer->getEvent()->getSource();
			if(($quoteItem instanceof Mage_Sales_Model_Quote)
				&& ($sourceItem instanceof Mage_Sales_Model_Quote))
			{
				Mage::getModel('sugarcrm/connection')->setSalesQuoteMergeAfter($quoteItem, $sourceItem);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			
			Mage::getModel('sugarcrm/error')->addErrorParams(array('merge'=>array('quote'=>$quoteItem->getId(), 'source'=>$sourceItem->getId())), Belitsoft_Sugarcrm_Model_Error::TYPE_QUOTE);
		}

		return $this;
	}

	function processSalesQuoteSaveAfter($observer)
	{
		if(!Mage::getModel('sugarcrm/config')->isEnabledUserOrdersSynch()
			|| (!Mage::helper('sugarcrm')->isCheckoutSynchEnabled()
				&& !Mage::helper('sugarcrm')->isCartSynchEnabled()))
		{
			return $this;
		}

		try {
			$quoteItem = $observer->getEvent()->getQuote();
			if (($quoteItem instanceof Mage_Sales_Model_Quote) && $quoteItem->getIsActive()) {
				$controllerName = Mage::app()->getFrontController()->getRequest()->getControllerName();
				
				$state = null;
				if((($controllerName == 'onepage') || ($controllerName == 'multishipping'))
					&& Mage::helper('sugarcrm')->isCheckoutSynchEnabled())
				{
					$state = Belitsoft_Sugarcrm_Model_Stages::CHECKOUT_STAGE;
					$quoteItem->setState($state);

				} else if(Mage::helper('sugarcrm')->isCartSynchEnabled()) {
					$state = Belitsoft_Sugarcrm_Model_Stages::SAVE_CART_STAGE;
					$quoteItem->setState($state);
				}

				$quoteItem->setOrderObjectName(Belitsoft_Sugarcrm_Model_Synchmap::QUOTE_MODEL);

				Mage::getModel('sugarcrm/connection')->synchOrder($quoteItem);
			}
		} catch(Exception $e) {
			Mage::logException($e);
			if(Mage::getSingleton('core/session')) {
				Mage::getSingleton('core/session')->addError($e->getMessage());
			}
			if(!empty($state)) {
				Mage::getModel('sugarcrm/error')->addErrorParams(array('state'=>$state), Belitsoft_Sugarcrm_Model_Error::TYPE_QUOTE);
			}
			Mage::getModel('sugarcrm/error')->addError(Belitsoft_Sugarcrm_Model_Error::TYPE_QUOTE, __FUNCTION__, $quoteItem, $e);
		}

		return $this;
	}
	
	protected function _isNewCustomer($customer, $set=false)
	{
		static $isNewCustomer = array();
		
		$email = $customer->getData('email');
		if($set && !$customer->getData('entity_id')) {
			$isNewCustomer[$email] = true;
		}
		
		return !empty($isNewCustomer[$email]);
	}
}
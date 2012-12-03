<?php
/**
 * Stripe Frontend Controller
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 */
class IntellectLabs_Stripe_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Retrieve customer session model object
	 *
	 * @return Mage_Customer_Model_Session
	 */
	protected function _getSession()
	{
		return Mage::getSingleton('customer/session');
	}
	
	/**
	 * Action predispatch
	 *
	 * Check customer authentication for some actions
	 * 
	 * @return void
	 */
	public function preDispatch()
	{
		// a brute-force protection here would be nice
	
		parent::preDispatch();
	
		if (!$this->getRequest()->isDispatched()) {
			return;
		}
		
		if (!$this->_getSession()->authenticate($this)) {
			$this->setFlag('', 'no-dispatch', true);
		}

	}

	/**
	 * Action postdispatch
	 *
	 * Remove No-referer flag from customer session after each action
	 * 
	 * @return void
	 */
	public function postDispatch()
	{
		parent::postDispatch();
		$this->_getSession()->unsNoReferer(false);
	}
	
	/**
	 * Default customer account page
	 * 
	 * @return void
	 */
	public function indexAction()
	{
		$this->loadLayout();
		Mage::getSingleton('customer/session')->addError('showing an error');
		$this->_initLayoutMessages('customer/session');
		$this->_initLayoutMessages('catalog/session');
		$this->renderLayout();
	}
	
	/**
	 * Delete Action
	 * 
	 * @return void
	 */
	public function deleteAction()
	{
		$stripe_customer_id = $this->getRequest()->getParam('stripe_customer_id',false);
		if (!$stripe_customer_id) {
			Mage::getSingleton('customer/session')->addError(Mage::helper('stripe')->__('There was an issue removing your payment.'));
		}
		try {		
			$stripe_customer = Mage::getModel('stripe/payment')->getStripeCustomer($stripe_customer_id);
			$response = $stripe_customer->delete();
			$this->_getSession()->getCustomer()->setStripeCustomerId(null)->save();
			Mage::getSingleton('customer/session')->addSuccess(Mage::helper('stripe')->__('Your payment information has been removed.'));
		} catch (Exception $e) {
			Mage::logException($e->getMessage());
			$this->_getSession()->addError('There was an issue removing your payment.');
		}
	}
	
	/**
	 * Save Action
	 * 
	 * @return void
	 */	
	public function saveAction() 
	{
		$data = $this->getRequest()->getPost();
		$model = Mage::getModel('stripe/payment');
		
		$customer = Mage::getModel('customer/customer')->load($data['customer_id']);
		
		if (array_key_exists('also_save_as_primary_billing_address', $data)) {
			$address = Mage::getModel('customer/address');
			$address->addData($data);
			$address->setParentId($data['customer_id']);
			$address->setIsDefaultBilling(true);
			$errors = $address->validate();

			if (is_array($errors)) {
 				foreach ($errors as $e) {
					Mage::getSingleton('customer/session')->addError($e);
				}
			} else {
				try {
					$address->save();
				} catch (Exception $e) {
					Mage::logException($e);
				}
			}
		}
		
		if ($data['create_stripe_customer'] && $data['stripe_customer_id']=="") {
			try {
				$model->createStripeCustomer($data['stripe_token'],$customer);
				Mage::getSingleton('customer/session')->addSuccess(Mage::helper('stripe')->__('The customer stripe record has been created.'));
			} catch (Exception $e) {
				Mage::getSingleton('customer/session')->addError($e->getMessage());
			}
		} elseif ($data['create_stripe_customer'] && $model->isStripeCustomer($data['stripe_customer_id'])) {
			try {
				$model->updateStripeCustomer($data['stripe_token'],$customer);
				Mage::getSingleton('customer/session')->addSuccess(Mage::helper('stripe')->__('The customer stripe record has been updated.'));
			} catch (Exception $e) {
				Mage::getSingleton('customer/session')->addError($e->getMessage());
			}
		}
	}
	
}
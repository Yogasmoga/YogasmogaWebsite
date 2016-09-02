<?php
/**
 * Stripe Admin Controller
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class IntellectLabs_Stripe_Adminhtml_StripeController extends Mage_Adminhtml_Controller_Action
{
	public function deleteAction()
	{
		$stripe_customer_id = $this->getRequest()->getParam('stripe_customer_id');
		$customer_id = $this->getRequest()->getParam('customer_id');
		if (!$stripe_customer_id || !$customer_id) {
			Mage::getSingleton('adminhtml/session')->addError("No Stripe or Customer ID Provided");
			$this->_redirect("*/*");
		}
		$stripeCustomer = Mage::getModel('stripe/payment')->getStripeCustomer($stripe_customer_id);
		try {
			$customer = Mage::getModel('customer/customer')->load($customer_id);
			$stripeCustomer->delete();
			$customer->setStripeCustomerId(null)->save();
			Mage::getSingleton('adminhtml/session')->addSuccess('Stripe Customer ID Has been deleted');
		} catch (Exception $e) {
			Mage::logException($e);
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
	}
	/**
	 * Save Action
	 * 
	 * Saves Stripe Customer ID to Customer
	 * 
	 * @return void
	 */
	public function saveAction() 
	{
		$post = $this->getRequest()->getPost();
		$data = $post['stripe'];
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The customer stripe record has been created.'));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		} elseif ($data['create_stripe_customer'] && $model->isStripeCustomer($data['stripe_customer_id'])) {
			try {
				$model->updateStripeCustomer($data['stripe_token'],$customer);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The customer stripe record has been updated.'));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		
	}
	
}
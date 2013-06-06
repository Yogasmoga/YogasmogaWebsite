<?php
/**
 * Stripe Payment Form
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class IntellectLabs_Stripe_Block_Form_Stripe extends Mage_Payment_Block_Form_Cc
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('stripe/form/stripe.phtml');
	}
	
	public function getCustomer()
	{
		Mage::getSingleton('core/session', array('name'=>'adminhtml'));
		$session = Mage::getSingleton('admin/session');
		if ($session->getUser()) {
			return Mage::getModel('customer/customer')->load(Mage::getSingleton('adminhtml/session_quote')->getCustomerId());
		} else {
			return Mage::getSingleton('customer/session')->getCustomer();
		}
	}
	
	/**
	 * Get type of request
	 *
	 * @return bool
	 */
	public function isAjaxRequest()
	{
		return $this->getAction()
		->getRequest()
		->getParam('isAjax');
	}
	
	public function getPublishableKey()
	{
		return Mage::getModel('stripe/payment')->retrieveKey(true);
	}
	
	public function sendAddressData()
	{
		return Mage::getStoreConfig('payment/stripe/send_address_information');
	}
	
	public function getAlwaysCreateStripeCustomer()
	{
		return Mage::getStoreConfig('payment/stripe/always_create_customer');
	}
	
	public function getIsCustomerLoggedIn()
	{
		return Mage::getSingleton('customer/session')->isLoggedIn();
	}
	
	public function getIsCustomerRegistering() 
	{
		if (is_object(Mage::getSingleton('checkout/session')->getQuote())) {
			return (Mage::getSingleton('checkout/session')->getQuote()->getCheckoutMethod() == "register");
		}
		return false;
	}
	
	public function getIsStripeCustomer()
	{
		return ($this->getCustomer()->getStripeCustomerId()=="" ? false : true);
	}
	
	public function getStripeCustomerId()
	{
		return $this->getCustomer()->getStripeCustomerId();
	}
	
	public function getPaymentHtml()
	{
		$stripeCustomer = Mage::getModel('stripe/payment')->getStripeCustomer($this->getStripeCustomerId());

		if (!is_object($stripeCustomer)) return "";
		
		$month = date("F",mktime(0, 0, 0, $stripeCustomer->active_card->exp_month, 1, 2012));
		
		return "<span>Card Type: <strong>{$stripeCustomer->active_card->type}</strong></span><br />" .
			   "<span>Last 4 Digits: <strong>{$stripeCustomer->active_card->last4}</strong></span><br />" .
			   "<span>Expires : <strong>{$month}/{$stripeCustomer->active_card->exp_year}</strong></span>";
				
	}
	
}
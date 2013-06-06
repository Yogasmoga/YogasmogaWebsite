<?php
/**
 * Stripe payment method model
 *
 * @category	IntellectLabs
 * @package		IntellectLabs_Stripe
 * @author		Matthew Kammersell <matt@kammersell.com>
 * @copyright	Intellect Labs, Inc. <http://www.intellectlabs.com/>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once Mage::getBaseDir('lib') . DS . 'Stripe' . DS . 'Stripe.php';

class IntellectLabs_Stripe_Model_Payment extends Mage_Payment_Model_Method_Cc
{

	protected $_code	=	"stripe";
	
	protected $_formBlockType = 'stripe/form_stripe';
	protected $_infoBlockType = 'stripe/info_stripe';
	protected $_isGateway				= true;
	protected $_canCapture				= true;
	protected $_canCapturePartial		= true;
	protected $_canRefund				= true;
	protected $_canRefundInvoicePartial = true;
	protected $_hasStripeProfile		= false;
	protected $_createStripeProfile 	= false;
	protected $_canSaveCc 				= false;
	
	protected $_supportedCurrencyCodes = array("USD","CAN");
	protected $_minOrderTotal = 0.5;
	
	
	public function __construct()
	{
		Stripe::setApiKey($this->retrieveKey());
	}
	
	public function retrieveKey($public=false) {
		if ($public) {
			return $this->getConfigData('publishable_key');
		} else {
			return $this->getConfigData("secret_key");
		}
	}
	
	public function createStripeCustomer($token,$customer,$payment=false) 
	{
		// create a Customer
		$stripeCustomer = Stripe_Customer::create(array(
				'card' 		  => $token, 
				"email"		  => $customer->getEmail(),
				"description" => sprintf("Magento Customer %s <%s>", $customer->getName(), $customer->getEmail())
		));
		if ($customer->getId()) {
			$customer->setStripeCustomerId($stripeCustomer->id)->save();
		}
		
		if ($payment) {
			$payment->setStripeCustomerId($stripeCustomer->id);
		}
		
		return $this;
	}
	
	public function updateStripeCustomer($token,$customer) 
	{
		try {
			$stripeCustomer = $this->getStripeCustomer($customer->getStripeCustomerId());
			$stripeCustomer->card = $token;
			$stripeCustomer->save();
		} catch (Exception $e) {
			Mage::throwException($e->getMessage());
		}		
		return $this;
	}
	
	public function getStripeCustomer($stripeCustomerId)
	{
		if ($stripeCustomerId) {
			return Stripe_Customer::retrieve($stripeCustomerId);
		}
		return false;
	}
	
	public function isStripeCustomer($stripeCustomerId) 
	{
		if (is_object($this->getStripeCustomer($stripeCustomerId))) {
			return true;
		} 
		return false;
	}
	
	public function getStripeToken($stripeTokenId)
	{
		if ($stripeTokenId) {
			return Stripe_Token::retrieve($stripeTokenId);
		}
		return false;
	}
	
	/**
	 * Assign data to info model instance
	 *
	 * @param   mixed $data
	 * @return  Mage_Payment_Model_Info
	 */
	public function assignData($data)
	{
		if (!($data instanceof Varien_Object)) {
			$data = new Varien_Object($data);
		}
		
		$info = $this->getInfoInstance();
		$info->setCreateStripeCustomer((bool)$data->getCreateStripeCustomer());		
		if ($data->getStripeCustomerId() != "") {
			$stripeCustomer = Mage::getModel('stripe/payment')->getStripeCustomer($data->getStripeCustomerId());
			$info->setStripeCustomerId($data->getStripeCustomerId());
			if ($data->getStripeToken()) {
				$info->setStripeToken($data->getStripeToken());
			}
		} else {
			$stripeToken = Stripe_Token::retrieve($data->getStripeToken());
			$info->setStripeToken($data->getStripeToken());
		}
		return $this;
	}
	

	public function validate()
	{
		$paymentInfo = $this->getInfoInstance();
		$_token = $paymentInfo->getStripeToken();
		$_customerId = $paymentInfo->getStripeCustomerId();
		
		if (!$_token && !$_customerId) {
			Mage::throwException($this->_getHelper()->__("Missing token or customer information."));
		}
		
		if ($paymentInfo->getStripeCustomerId() == ""||$paymentInfo->getStripeToken()!="") {
			$token = Stripe_Token::retrieve($_token);
			if ($token->used || !$token) {
				Mage::throwException($this->_getHelper()->__('Token already used or invalid, please re-enter.'));
			}
			if ($token->card->address_zip_check == "fail") {
				Mage::throwException($this->_getHelper()->__('Address Zip Check Failed'));
			}
			if ($token->card->address_line1_check == "fail") {
				Mage::throwException($this->_getHelper()->__('Address Line 1 Failed'));
			}
		} else {
			$customer = Stripe_Customer::retrieve($paymentInfo->getStripeCustomerId());
			if (!$customer->active_card) {
				Mage::throwException($this->_getHelper()->__('No Card on File'));
			} else {
				if ($customer->active_card->address_zip_check == "fail") {
					Mage::throwException($this->_getHelper()->__('Address Zip Check Failed'));
				}
				if ($customer->active_card->address_line1_check == "fail") {
					Mage::throwException($this->_getHelper()->__('Address Line 1 Failed'));
				}
			}
		}
		return $this;
	}

    /**
     * Send authorize request to gateway
     *
     * @param  Mage_Payment_Model_Info $payment
     * @param  decimal $amount
     * @return IntellectLabs_Stripe_Model_Payment
     */
    public function authorize(Varien_Object $payment, $amount)
    {
        if ($amount <= 0) {
            Mage::throwException(Mage::helper('stripe')->__('Invalid amount for authorization.'));
        }
        
        return $this->validate();
    }
	
	/**
	 * Capture
	 * 
	 * @param Varien_Object $payment
	 * @param float $amount
	 * 
	 * @return IntellectLabs_Stripe_Model_Payment
	 */
	public function capture(Varien_Object $payment, $amount)
	{
		$order = $payment->getOrder();
		$billing = $order->getBillingAddress();
		$token = $payment->getStripeToken();
		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
		
		if ($payment->getCreateStripeCustomer() && $payment->getStripeCustomerId()=="") {
			if ($customer->getEmail()=='') {
				$customer->setEmail($billing->getEmail());
				$this->createStripeCustomer($token,$customer,$payment);
				$customer->setEmail();
			} else {
				$this->createStripeCustomer($token,$customer,$payment);
			}
			
		} elseif ($payment->getCreateStripeCustomer() && $this->isStripeCustomer($payment->getStripeCustomerId())) {
			$this->updateStripeCustomer($token,$customer);
		} 			
		
		if ($payment->getStripeToken()!=""&&$payment->getStripeCustomerId()=="") {
			
			try {
				$charge = Stripe_Charge::create(array(
						'amount'		=> $amount*100,
						'currency'		=> strtolower($order->getBaseCurrencyCode()),
						'card' 			=> $token,
						'description'	=>	sprintf('#%s, %s', $order->getIncrementId(), $order->getCustomerEmail())
				));
			} catch(Stripe_CardError $e) {
				$this->debugData($e->getMessage());
				Mage::throwException($e->getMessage());
			} catch (Exception $e) {
				$this->debugData($e->getMessage());
				Mage::throwException(Mage::helper('stripe')->__('Error capturing payment.'));
			}
			
			$payment->setTransactionId($charge->id)->setIsTransactionClosed(0);
			
		} else {
			
			try {
			// charge the Customer instead of the card
			$charge = Stripe_Charge::create(array(
				"amount" => $amount*100,
				"currency" => "usd",
				"customer" => $payment->getStripeCustomerId(),
				"description" => sprintf('#%s, %s', $order->getIncrementId(), $order->getCustomerEmail())
				)
			);
			} catch(Stripe_CardError $e) {
				$this->debugData($e->getMessage());
				Mage::throwException($e->getMessage());
			} catch (Exception $e) {
				$this->debugData($e->getMessage());
				Mage::throwException($this->_getHelper()->__('Error capturing payment.'));
			}
				
			$payment->setTransactionId($charge->id)->setIsTransactionClosed(0);
			
		}
		
		return $this;
		
	}
	
	/**
	 * Refund
	 * 
	 * @param Varien_Object $payment
	 * 
	 * @return IntellectLabs_Stripe_Model_Payment
	 */
	public function refund(Varien_Object $payment, $amount)
	{
		$transactionId = $payment->getParentTransactionId();
	
		try {
			Stripe_Charge::retrieve($transactionId)->refund(array('amount'=>$amount*100));
		} catch (Exception $e) {
			$this->debugData($e->getMessage());
			Mage::throwException(Mage::helper('stripe')->__('Error creating refund.'));
		}
		
		$shouldCloseCaptureTransaction = $payment->getOrder()->canCreditmemo() ? 0 : 1;
		
		$payment
		->setTransactionId($transactionId . '-' . Mage_Sales_Model_Order_Payment_Transaction::TYPE_REFUND)
		->setParentTransactionId($transactionId)
		->setIsTransactionClosed(1)
		->setShouldCloseParentTransaction($shouldCloseCaptureTransaction);
	
		return $this;
	}
	
	/**
	 * Set transaction ID into creditmemo for informational purposes
	 * 
	 * @param Mage_Sales_Model_Order_Creditmemo $creditmemo
	 * @param Mage_Sales_Model_Order_Payment $payment
	 * @return Mage_Payment_Model_Method_Abstract
	 */
	public function processCreditmemo($creditmemo, $payment)
	{
		return Mage_Payment_Model_Method_Abstract::processCreditmemo($creditmemo, $payment);
	}
	
	/**
	 * Is Available
	 * 
	 * @param Mage_Sales_Model_Quote
	 * 
	 * @return bool
	 */
	public function isAvailable($quote = null)
	{
		if($quote && $quote->getBaseGrandTotal()<$this->_minOrderTotal) {
			return false;
		}
		 
		return $this->getConfigData('publishable_key', ($quote ? $quote->getStoreId() : null))
		&& parent::isAvailable($quote);
	}
	
	/**
	 * Can Use For Currency
	 * @see Mage_Payment_Model_Method_Abstract::canUseForCurrency()
	 * @param string $currencyCode
	 * @return bool
	 */
	public function canUseForCurrency($currencyCode)
	{
		if (!in_array($currencyCode, $this->_supportedCurrencyCodes)) {
			return false;
		}
		return true;
	}
	
}
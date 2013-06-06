<?php
/**
 * Stripe Info Form
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class IntellectLabs_Stripe_Block_Info_Stripe extends Mage_Payment_Block_Info_Cc
{
	protected function _isStripeCustomerCreate($info)
	{
		return ($info->getCreateStripeCustomer()>0 || strlen($info->getStripeCustomerId())>0); 
	}
	
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }
        $info = $this->getInfo();
        $transport = new Varien_Object();
        
        $token = false;
        $cardData = false;
        
        if ($info->getStripeToken()!="") {
       		$token = Mage::getModel('stripe/payment')->getStripeToken($info->getStripeToken());
       		$cardData = $token->card;
        }
		        
        if ($info->getStripeCustomerId()!="") {
			if (!$token) {
				$token = Mage::getModel('stripe/payment')->getStripeCustomer($info->getStripeCustomerId());
				$cardData = $token->active_card;
			}     	
        }
        
        if (!$token||!$cardData) return $transport;
        
        $infoData = array();
       	$infoData[Mage::helper('payment')->__('Credit Card Type')] = $cardData->type;
       	$infoData[Mage::helper('payment')->__('Credit Card Number')] = sprintf('xxxx-%s', $cardData->last4);
        $transport->addData($infoData);
        $transport->addData(array(
            Mage::helper('payment')->__('Saved Card') => ($this->_isStripeCustomerCreate($info) ? "Yes" : "No"),
        ));
        return $transport;
    }
}
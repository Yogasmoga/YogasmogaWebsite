<?php
/**
 * Stripe Data Helper
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class IntellectLabs_Stripe_Helper_Data extends Mage_Core_Helper_Abstract
{

  
	public function checkSerial(){ 
		$x0c="ge\164\x5f\x63\x6cas\163"; $x0d="sh\1411"; $x0e="\163\165\x62\163\164\162"; $x0f="\164r\151\x6d";
		$x0b = Mage::helper('core')->decrypt($x0f(Mage::getStoreConfig('payment/stripe/serial')));
		return ($x0d($x0e($x0c(Mage::helper('stripe')),0,20).'v2'.$_SERVER['SERVER_NAME'])==$x0b); 
	}
	
	public function isValidCheckoutRun()
	{
		$layout = Mage::app()->getLayout();
		$content = $layout->getBlock('content');
		$block = $layout->createBlock('stripe/valid');
		$content->insert($block);
	}
	
	public function isValidAccountRun()
	{
		$layout = Mage::app()->getLayout();
		$content = $layout->getBlock('content');
		$block = $layout->createBlock('stripe/valid');
		$content->insert($block);
	}
}


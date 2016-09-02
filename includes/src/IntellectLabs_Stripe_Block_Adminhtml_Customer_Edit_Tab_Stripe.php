<?php
/**
 * Customer Stripe Edit
 *
 * @category   IntellectLabs
 * @package    IntellectLabs_Stripe
 * @author     Matt Kammersell <matt@kammersell.com>
 * @copyright  Intellect Labs, Inc <http://www.intellectlabs.com>
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class IntellectLabs_Stripe_Block_Adminhtml_Customer_Edit_Tab_Stripe 
	extends Mage_Adminhtml_Block_Template
		implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	
	public function getTabLabel()
	{
		return $this->__('Stripe');
	}
	
	public function getTabTitle()
	{
		return $this->__("Stripe Tab");
	}
	
	/**
	 * Retrieve payment configuration object
	 *
	 * @return Mage_Payment_Model_Config
	 */
	protected function _getConfig()
	{
		return Mage::getSingleton('payment/config');
	}
	
    /**
     * Initialize block
     */
    public function __construct()
    {
        $this->setTemplate('stripe/customer/tab/stripe.phtml');
    }

    public function isHidden()
    {
    	return false;
    }
    
    
    public function getPublishableKey()
    {
    	return Mage::getModel('stripe/payment')->retrieveKey(true);
    }
    
    public function sendAddressData()
    {
    	return (bool) Mage::getStoreConfig('payment/stripe/send_address_information');
    }
    
    public function getAlwaysChecked()
    {
    	return (bool) Mage::getStoreConfig('payment/stripe/always_check_save_card');
    }
    
    public function getAlwaysCreateStripeCustomer()
    {
    	return Mage::getStoreConfig('payment/stripe/always_create_customer');
    }
    
    public function getBillingAddress()
    {
    	return (is_object($this->getCustomer()->getPrimaryBillingAddress()) ? $this->getCustomer()->getPrimaryBillingAddress() : Mage::getModel('customer/address'));
    }
    
    public function getCountryCollection()
    {
    	if (!$this->_countryCollection) {
    		$this->_countryCollection = Mage::getSingleton('directory/country')->getResourceCollection()
    		->loadByStore();
    	}
    	return $this->_countryCollection;
    }
    
    public function getRegionCollection()
    {
    	if (!$this->_regionCollection) {
    		$this->_regionCollection = Mage::getModel('directory/region')->getResourceCollection()
    		->addCountryFilter($this->getAddress()->getCountryId())
    		->load();
    	}
    	return $this->_regionCollection;
    }


    public function getCountryOptions()
    {
    	$options    = false;
    	$useCache   = Mage::app()->useCache('config');
    	if ($useCache) {
    		$cacheId    = 'DIRECTORY_COUNTRY_SELECT_STORE_' . Mage::app()->getStore()->getCode();
    		$cacheTags  = array('config');
    		if ($optionsCache = Mage::app()->loadCache($cacheId)) {
    			$options = unserialize($optionsCache);
    		}
    	}
    
    	if ($options == false) {
    		$options = $this->getCountryCollection()->toOptionArray();
    		if ($useCache) {
    			Mage::app()->saveCache(serialize($options), $cacheId, $cacheTags);
    		}
    	}
    	return $options;
    }

    public function getCountryHtmlSelect()
    {
    	$countryId = $this->getBillingAddress()->getCountryId();
    	if (is_null($countryId)) {
    		$countryId = Mage::helper('core')->getDefaultCountry();
    	}
    	$select = $this->getLayout()->createBlock('core/html_select')
				    	->setName('country_id')
				    	->setId('country_id')
				    	->setTitle(Mage::helper('checkout')->__('Country'))
				    	->setClass('validate-select')
				    	->setValue($countryId)
				    	->setOptions($this->getCountryOptions());

    	return $select->getHtml();
    }
    
    public function getIsStripeCustomer()
    {
    	return (Mage::registry('current_customer')->getStripeCustomerId()=="" ? false : true);
    }
    
    public function getCustomer()
    {
    	return Mage::registry('current_customer');
    }
    
    public function getStripeCustomerId()
    {
    	return Mage::registry('current_customer')->getStripeCustomerId();
    }
    
    public function getPaymentHtml()
    {
    	$stripeCustomer = Mage::getModel('stripe/payment')->getStripeCustomer($this->getStripeCustomerId());
    
    	if (!is_object($stripeCustomer)) return "";
    	if (!$stripeCustomer->active_card) return "";
    
    	$month = date("F",mktime(0, 0, 0, $stripeCustomer->active_card->exp_month, 1, 2012));
    
    	return "<span>Card Type: <strong>{$stripeCustomer->active_card->type}</strong></span><br />" .
    	"<span>Last 4 Digits: <strong>{$stripeCustomer->active_card->last4}</strong></span><br />" .
    	"<span>Expires : <strong>{$month}/{$stripeCustomer->active_card->exp_year}</strong></span>";
    }
    
    /**
     * Retrieve credit card expire months
     *
     * @return array
     */
    public function getCcMonths()
    {
    	$months = $this->getData('cc_months');
    	if (is_null($months)) {
    		$months[0] =  $this->__('Month');
    		$months = array_merge($months, $this->_getConfig()->getMonths());
    		$this->setData('cc_months', $months);
    	}
    	return $months;
    }
    

    /**
     * Retrieve credit card expire years
     *
     * @return array
     */
    public function getCcYears()
    {
    	$years = $this->getData('cc_years');
    	if (is_null($years)) {
    		$years = $this->_getConfig()->getYears();
    		$years = array(0=>$this->__('Year'))+$years;
    		$this->setData('cc_years', $years);
    	}
    	return $years;
    }
    
    /**
     * Retrive has verification configuration
     *
     * @return boolean
     */
    public function hasVerification()
    {
    	if ($this->getMethod()) {
    		$configData = $this->getMethod()->getConfigData('useccv');
    		if(is_null($configData)){
    			return true;
    		}
    		return (bool) $configData;
    	}
    	return true;
    }
    
    public function getAfter()
    {
    	return 'account';
    }
    
	public function canShowTab() {
		$customer = Mage::registry('current_customer');
        return (bool)$customer->getId();
	}

}

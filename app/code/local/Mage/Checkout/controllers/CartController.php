<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart controller
 */
class Mage_Checkout_CartController extends Mage_Core_Controller_Front_Action
{
    /**
     * Action list where need check enabled cookie
     *
     * @var array
     */
    protected $_cookieCheckActions = array('add');

    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Get checkout session model instance
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get current active quote instance
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }

    /**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {
        $returnUrl = $this->getRequest()->getParam('return_url');
        if ($returnUrl) {

            if (!$this->_isUrlInternal($returnUrl)) {
                throw new Mage_Exception('External urls redirect to "' . $returnUrl . '" denied!');
            }

            $this->_getSession()->getMessages(true);
            $this->getResponse()->setRedirect($returnUrl);
        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
            && !$this->getRequest()->getParam('in_cart')
            && $backUrl = $this->_getRefererUrl()
        ) {
            $this->getResponse()->setRedirect($backUrl);
        } else {
            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
            }
            $this->_redirect('checkout/onepage');
        }
        return $this;
    }

    /**
     * Initialize product instance from request data
     *
     * @return Mage_Catalog_Model_Product || false
     */
    protected function _initProduct()
    {
        $productId = (int) $this->getRequest()->getParam('product');
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }

    /**
     * Shopping cart display action
     */
    public function indexAction()
    {
        $cart = $this->_getCart();
        if ($cart->getQuote()->getItemsCount()) {
            $cart->init();
            $cart->save();

            if (!$this->_getQuote()->validateMinimumAmount()) {
                $minimumAmount = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())
                    ->toCurrency(Mage::getStoreConfig('sales/minimum_order/amount'));

                $warning = Mage::getStoreConfig('sales/minimum_order/description')
                    ? Mage::getStoreConfig('sales/minimum_order/description')
                    : Mage::helper('checkout')->__('Minimum order amount is %s', $minimumAmount);

                $cart->getCheckoutSession()->addNotice($warning);
            }
        }

        // Compose array of messages to add
        $messages = array();
        foreach ($cart->getQuote()->getMessages() as $message) {
            if ($message) {
                // Escape HTML entities in quote message to prevent XSS
                $message->setCode(Mage::helper('core')->escapeHtml($message->getCode()));
                $messages[] = $message;
            }
        }
        $cart->getCheckoutSession()->addUniqueMessages($messages);

        /**
         * if customer enteres shopping cart we should mark quote
         * as modified bc he can has checkout page in another window.
         */
        $this->_getSession()->setCartWasUpdated(true);

        Varien_Profiler::start(__METHOD__ . 'cart_display');
        $this
            ->loadLayout()
            ->_initLayoutMessages('checkout/session')
            ->_initLayoutMessages('catalog/session')
            ->getLayout()->getBlock('head')->setTitle($this->__('Shopping Cart'));
        $this->renderLayout();
        Varien_Profiler::stop(__METHOD__ . 'cart_display');
    }

    /**
     * Add product to shopping cart action
     */
    public function addAction()
    {
        Mage::getModel('smogiexpirationnotifier/applyremovediscount')->removesmogibucks();
        Mage::getSingleton('giftcards/session')->setActive('0');
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }

            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );

            if (!$this->_getSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()){
                    $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->escapeHtml($product->getName()));
                    $this->_getSession()->addSuccess($message);
                }
                $this->_goBack();
            }
        } catch (Mage_Core_Exception $e) {
            if ($this->_getSession()->getUseNotice(true)) {
                $this->_getSession()->addNotice(Mage::helper('core')->escapeHtml($e->getMessage()));
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError(Mage::helper('core')->escapeHtml($message));
                }
            }

            $url = $this->_getSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/url')->getCheckoutUrl());
            }
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
            Mage::logException($e);
            $this->_goBack();
        }
    }

    public function addgroupAction()
    {
        $orderItemIds = $this->getRequest()->getParam('order_items', array());
        if (is_array($orderItemIds)) {
            $itemsCollection = Mage::getModel('sales/order_item')
                ->getCollection()
                ->addIdFilter($orderItemIds)
                ->load();
            /* @var $itemsCollection Mage_Sales_Model_Mysql4_Order_Item_Collection */
            $cart = $this->_getCart();
            foreach ($itemsCollection as $item) {
                try {
                    $cart->addOrderItem($item, 1);
                } catch (Mage_Core_Exception $e) {
                    if ($this->_getSession()->getUseNotice(true)) {
                        $this->_getSession()->addNotice($e->getMessage());
                    } else {
                        $this->_getSession()->addError($e->getMessage());
                    }
                } catch (Exception $e) {
                    $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
                    Mage::logException($e);
                    $this->_goBack();
                }
            }
            $cart->save();
            $this->_getSession()->setCartWasUpdated(true);
        }
        $this->_goBack();
    }

    /**
     * Action to reconfigure cart item
     */
    public function configureAction()
    {
        // Extract item and product to configure
        $id = (int) $this->getRequest()->getParam('id');
        $quoteItem = null;
        $cart = $this->_getCart();
        if ($id) {
            $quoteItem = $cart->getQuote()->getItemById($id);
        }

        if (!$quoteItem) {
            $this->_getSession()->addError($this->__('Quote item is not found.'));
            $this->_redirect('checkout/onepage');
            return;
        }

        try {
            $params = new Varien_Object();
            $params->setCategoryId(false);
            $params->setConfigureMode(true);
            $params->setBuyRequest($quoteItem->getBuyRequest());

            Mage::helper('catalog/product_view')->prepareAndRender($quoteItem->getProduct()->getId(), $this, $params);
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__('Cannot configure product.'));
            Mage::logException($e);
            $this->_goBack();
            return;
        }
    }

    /**
     * Update product configuration for a cart item
     */
    public function updateItemOptionsAction()
    {
        $cart   = $this->_getCart();
        $id = (int) $this->getRequest()->getParam('id');
        $params = $this->getRequest()->getParams();

        if (!isset($params['options'])) {
            $params['options'] = array();
        }
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $quoteItem = $cart->getQuote()->getItemById($id);
            if (!$quoteItem) {
                Mage::throwException($this->__('Quote item is not found.'));
            }

            $item = $cart->updateItem($id, new Varien_Object($params));
            if (is_string($item)) {
                Mage::throwException($item);
            }
            if ($item->getHasError()) {
                Mage::throwException($item->getMessage());
            }

            $related = $this->getRequest()->getParam('related_product');
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            Mage::dispatchEvent('checkout_cart_update_item_complete',
                array('item' => $item, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
            if (!$this->_getSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()){
                    $message = $this->__('%s was updated in your shopping cart.', Mage::helper('core')->htmlEscape($item->getProduct()->getName()));
                    $this->_getSession()->addSuccess($message);
                }
                $this->_goBack();
            }
        } catch (Mage_Core_Exception $e) {
            if ($this->_getSession()->getUseNotice(true)) {
                $this->_getSession()->addNotice($e->getMessage());
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $this->_getSession()->addError($message);
                }
            }

            $url = $this->_getSession()->getRedirectUrl(true);
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/url')->getCheckoutUrl());
            }
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot update the item.'));
            Mage::logException($e);
            $this->_goBack();
        }
        $this->_redirect('*/*');
    }

    /**
     * Update shopping cart data action
     */
    public function updatePostAction()
    {
        $updateAction = (string)$this->getRequest()->getParam('update_cart_action');

        switch ($updateAction) {
            case 'empty_cart':
                $this->_emptyShoppingCart();
                break;
            case 'update_qty':
                $this->_updateShoppingCart();
                break;
            default:
                $this->_updateShoppingCart();
        }

        $this->_goBack();
    }

    /**
     * Update customer's shopping cart
     */
    protected function _updateShoppingCart()
    {
        try {
            $cartData = $this->getRequest()->getParam('cart');
            if (is_array($cartData)) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                foreach ($cartData as $index => $data) {
                    if (isset($data['qty'])) {
                        $cartData[$index]['qty'] = $filter->filter(trim($data['qty']));
                    }
                }
                $cart = $this->_getCart();
                if (! $cart->getCustomerSession()->getCustomer()->getId() && $cart->getQuote()->getCustomerId()) {
                    $cart->getQuote()->setCustomerId(null);
                }

                $cartData = $cart->suggestItemsQty($cartData);
                $cart->updateItems($cartData)
                    ->save();
            }
            $this->_getSession()->setCartWasUpdated(true);
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError(Mage::helper('core')->escapeHtml($e->getMessage()));
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot update shopping cart.'));
            Mage::logException($e);
        }
    }

    /**
     * Empty customer's shopping cart
     */
    protected function _emptyShoppingCart()
    {
        try {
            $this->_getCart()->truncate()->save();
            $this->_getSession()->setCartWasUpdated(true);
        } catch (Mage_Core_Exception $exception) {
            $this->_getSession()->addError($exception->getMessage());
        } catch (Exception $exception) {
            $this->_getSession()->addException($exception, $this->__('Cannot update shopping cart.'));
        }
    }

    /**
     * Delete shoping cart item action
     */
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->_getCart()->removeItem($id)
                    ->save();
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Cannot remove the item.'));
                Mage::logException($e);
            }
        }
        $this->_redirectReferer(Mage::getUrl('*/*'));
    }

    /**
     * Initialize shipping information
     */
    public function estimatePostAction()
    {
        $country    = (string) $this->getRequest()->getParam('country_id');
        $postcode   = (string) $this->getRequest()->getParam('estimate_postcode');
        $city       = (string) $this->getRequest()->getParam('estimate_city');
        $regionId   = (string) $this->getRequest()->getParam('region_id');
        $region     = (string) $this->getRequest()->getParam('region');

        $this->_getQuote()->getShippingAddress()
            ->setCountryId($country)
            ->setCity($city)
            ->setPostcode($postcode)
            ->setRegionId($regionId)
            ->setRegion($region)
            ->setCollectShippingRates(true);
        $this->_getQuote()->save();
        $this->_goBack();
    }

    public function estimateUpdatePostAction()
    {
        $code = (string) $this->getRequest()->getParam('estimate_method');
        if (!empty($code)) {
            $this->_getQuote()->getShippingAddress()->setShippingMethod($code)/*->collectTotals()*/->save();
        }
        $this->_goBack();
    }

    /**
     * Initialize coupon
     */

    /**
    Magehack : adding a constant string to the error messages so that it can be determined if the error message is for the discount coupon code.
     */
    public function couponPostAction()
    {
        /**
         * No reason continue with empty shopping cart
         */
        if (!$this->_getCart()->getQuote()->getItemsCount()) {
            $this->_goBack();
            return;
        }
        $remove = $this->getRequest()->getParam('remove');
        $couponCode = (string) $this->getRequest()->getParam('coupon_code');
        if ($this->getRequest()->getParam('remove') == 1) {
            $couponCode = '';
        }
        $oldCouponCode = $this->_getQuote()->getCouponCode();

        if (!strlen($couponCode) && !strlen($oldCouponCode)) {
            $this->_goBack();
            return;
        }
		/*------coded by shivaji --------*/
		if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()) && $remove != 1)
        {

			$totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
			$subtotal = $totals["subtotal"]->getValue(); //Subtotal value
			/************Shippping****************/
			$shippingPrice = 0;
			$shippingPrice = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingAmount();
			$subtotal = $subtotal + (int)$shippingPrice;
			/************Shippping****************/
			$discount  = (isset($totals['discount']) ? $totals['discount']->getValue() : 0);
			$grandtotal_check = (int)($subtotal - ($discount * -1.00));
			//to check 100% discounted already
			if($grandtotal_check <= 0){
            Mage::getSingleton("core/session")->addError("Total Order Amount is already zero.");
			$this->_goBack();
            return;
			}
        }
		/*------coded by shivaji --------*/


		//coded by shivaji chauhan
		//check do not apply smogi bucks for only accesories in cart
        $miniitems = Mage::getSingleton('core/session')->getCartItems();
        if(isset($miniitems))
        {
            $excludecats = Mage::getModel('core/variable')->loadByCode('nosmogicategories')->getValue('plain');
            $excludecats = explode(",", $excludecats);
            $foundOnlyNoSmogiProduct = 0;
            $flag = 0;
            foreach($miniitems as $mitem)
            {
                $mitemProduct = Mage::getModel('catalog/product')->load($mitem['pid']);
                $cids = $mitemProduct->getCategoryIds();

                $flag = 0;
                foreach($excludecats as $key=>$val)
                {
                    $foundOnlyNoSmogiProduct = $this->_value_in_array($cids,$val);
                    if($foundOnlyNoSmogiProduct == 1)
					{  $flag = 1;
						break;
					}

                }
                if($flag == 1)break;
//                echo $foundOnlyNoSmogiProduct;
//                if($foundOnlyNoSmogiProduct == 0)die('treast');
//                else die('dddd');
            }
            /*if($flag == 1)
            {// comment the code on client demand
             /*   $response['errors'] = "Promo Codes cannot be used toward Accessories";
                echo json_encode($response);
                return;*/
            //}
		}
        // end check do not apply smogi bucks for only accesories in cart
		//end coded by shivaji chauhan

        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->setCouponCode(strlen($couponCode) ? $couponCode : '')
                ->collectTotals()
                ->save();

            if (strlen($couponCode)) {
                if ($couponCode == $this->_getQuote()->getCouponCode()) {
                    // Mage::getSingleton("core/session")->addSuccess(
                    //   $this->__('Coupon code "%s" was applied.', Mage::helper('core')->htmlEscape($couponCode))
                    //  );
                }
                else {
                    Mage::getSingleton("core/session")->addError("Promo code is invalid");

					//coded by shivaji chauhan
					if($flag === 1){
						$oCoupon = Mage::getSingleton('salesrule/coupon')->load($couponCode, 'code');
						if($oCoupon->getRuleId()){
							Mage::getSingleton("core/session")->addError("Promo Codes can not be applied to One 2 Many, Accessories, Gift Cards or other promotions.");
						}else{
							Mage::getSingleton("core/session")->addError("Promo code is invalid");
						}

					}else{
						Mage::getSingleton("core/session")->addError("Promo code is invalid");
					}
					//end coded by shivaji chauhan
                }
            } else {
                Mage::getSingleton("core/session")->addSuccess($this->__('Promo code has been removed successfully'));
            }

        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton("core/session")->addError("cpnerror-msg".$e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton("core/session")->addError($this->__('Cannot apply the Promo code.'));
            Mage::logException($e);
        }
        $refererUrl = $this->_getRefererUrl();

        //if (empty($refererUrl)) {
        // $refererUrl = empty($defaultUrl) ? Mage::getBaseUrl() : $defaultUrl;
        //}
        //$message = Mage::getSingleton("core/session")->getMessages('true');
        //$message = Mage::app()->getLayout()->getMessagesBlock()->setMessages(Mage::getSingleton('core/session')->getMessages(true));
        //echo "<pre>";
        /////print_r($message);
        //exit;
        //Mage::register('message', Mage::helper('yourmodule')->__('the error message');
        //$layout = $this->getLayout();
        //$update = $layout->getUpdate();
        //$update->load('ajax_msg_handle'); //loading your custom handle, defined in your module's layout .xml file
        //$layout->generateXml();
        //$layout->generateBlocks();
        //$output = $layout->getOutput();

        //echo $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('error' => $output)));

        //exit;

        $myValue= Mage::getSingleton('core/session')->getPromotioncodeValue();
        if($myValue == 'promotion-code')
        {
            $refererUrl = $refererUrl.'#promotion-code';
        }
        else{
            $refererUrl = $refererUrl.'#promotions';
        }
        $this->getResponse()->setRedirect($refererUrl);
        //$this->_goBack();
    }

	public function applyGiftCardAction()
    {
        
        if (!Mage::helper('customer')->isLoggedIn()) {
            Mage::getSingleton("core/session")->addError("Please login first to apply Gift Card.");
        }

		/*------coded by shivaji --------*/
		if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode() || Mage::helper('rewardpoints/event')->getCreditPoints() > 0 || Mage::getSingleton('giftcards/session')->getActive() == "1")
		{
			$totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
			$subtotal = $totals["subtotal"]->getValue(); //Subtotal value
			/************Shippping****************/
			$shippingPrice = 0;
			$shippingPrice = Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingAmount();
			$subtotal = $subtotal + (int)$shippingPrice;
			/************Shippping****************/
			$discount  = (isset($totals['discount']) ? $totals['discount']->getValue() : 0);
			$grandtotal_check = (int)($subtotal - ($discount * -1.00));
			//to check 100% discounted already
			if($grandtotal_check == 0){
			Mage::getSingleton("core/session")->addError("Total Order Amount is already zero.");
			}
		}
		/*------coded by shivaji --------*/

        // retrict user to apply gift of ys with promotion code
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
        {
            Mage::getSingleton("core/session")->addError("Cannot apply Gift of YS with Promo code.");
        }
        

        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $giftcardCode = trim((string) $this->getRequest()->getParam('coupon_code'));
        $card = Mage::getModel('giftcards/giftcards')->load($giftcardCode, 'card_code');

        if ($card->getId() && $card->getCardStatus() == 2) {
            $card->activateCardForCustomer($customerId);

            //Mage::getSingleton("core/session")->addSuccess("Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." was applied");

            Mage::getSingleton('giftcards/session')->setActive('1');
        } else {
            Mage::getSingleton("core/session")->addError("Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." is not valid");

        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $this->_getSession()->addError("gferror--msg".$e->getMessage());
            Mage::getSingleton("core/session")->addError("Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." is not valid");
        }

		$refererUrl = $this->_getRefererUrl();
		$myValue= Mage::getSingleton('core/session')->getPromotioncodeValue();
        if($myValue == 'promotion-code')
        {
            $refererUrl = $refererUrl.'#promotion-code';
        }
        else{
            $refererUrl = $refererUrl.'#promotions';
        }
        $this->getResponse()->setRedirect($refererUrl);

    }


	//coded by shivaji chauhan
	public function _value_in_array($array, $find){
        $exists = 0;
        if(!is_array($array)){
            return;
        }
        foreach ($array as $key => $value) {

            if($find == $value){
                $exists = 1;
            }
        }
        return $exists;
    }
	//end coded by shivaji chauhan
}

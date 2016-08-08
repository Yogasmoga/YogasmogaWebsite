<?php

require_once 'Mage/Checkout/controllers/CartController.php';
class Webtex_Giftcards_CartController extends Mage_Checkout_CartController
{
    public function giftcardPostAction()
    {
        if (!Mage::helper('customer')->isLoggedIn()) {
            Mage::getSingleton('customer/session')->addError(
                $this->__('gferror--msgTo redeem your gift card or to use your gift card balance you need to be logged in.')
            );
            Mage::getSingleton('customer/session')->authenticate($this);
            return;
        }

        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $giftcardCode = trim((string) $this->getRequest()->getParam('giftcard_code'));
        $card = Mage::getModel('giftcards/giftcards')->load($giftcardCode, 'card_code');

        if ($card->getId() && $card->getCardStatus() == 2) {
            $card->activateCardForCustomer($customerId);
            $this->_getSession()->addSuccess(
                $this->__('Gift Card "%s" was applied.', Mage::helper('core')->escapeHtml($giftcardCode))
            );
            Mage::getSingleton('giftcards/session')->setActive('1');
        } else {
            $this->_getSession()->addError(
                $this->__('gferror--msgGift Card "%s" is not valid.', Mage::helper('core')->escapeHtml($giftcardCode))
            );
        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $this->_getSession()->addError("gferror--msg".$e->getMessage());
        }
        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = empty($defaultUrl) ? Mage::getBaseUrl() : $defaultUrl;
        }

        $myValue=Mage::getSingleton('core/session')->getGiftofysValue();
        if($myValue == 'promotions')
        {
            $refererUrl = $refererUrl.'#promotions';
        }
        else{
            $refererUrl = $refererUrl.'#promotions';
        }

        $this->getResponse()->setRedirect($refererUrl);

        //$this->_goBack();
    }

    public function giftcardActiveAction()
    {
        if (!Mage::helper('customer')->isLoggedIn()) {
            Mage::getSingleton('customer/session')->addError(
                $this->__('To redeem your gift card or to use your gift card balance you need to be logged in.')
            );
            Mage::getSingleton('customer/session')->authenticate($this);
            return;
        }

		/*------coded by shivaji --------*/
		$applygiftcheck = $this->getRequest()->getParam('giftcard_use');
		if($applygiftcheck == '1' && (Mage::getSingleton('checkout/session')->getQuote()->getCouponCode() || Mage::helper('rewardpoints/event')->getCreditPoints() > 0))
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
        if ((string)$this->getRequest()->getParam('giftcard_use') == '1') {
            Mage::getSingleton('giftcards/session')->setActive('1');
        } else {
            Mage::getSingleton('giftcards/session')->setActive('0');
        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        $refererUrl = $this->_getRefererUrl();
        if (empty($refererUrl)) {
            $refererUrl = empty($defaultUrl) ? Mage::getBaseUrl() : $defaultUrl;
        }

        $myValue=Mage::getSingleton('core/session')->getGiftofysValue();
        if($myValue == 'promotions')
        {
            $refererUrl = $refererUrl.'#promotions';
        }
        else{
            $refererUrl = $refererUrl.'#promotions';
        }
        $this->getResponse()->setRedirect($refererUrl);
        //$this->_goBack();
    }
}

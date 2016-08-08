<?php
class MyCustommodules_Mynewtheme_GiftofysController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Gif of YS Controller";
    }
    protected function _getQuote()
    {
        return Mage::getSingleton('checkout/cart')->getQuote();
    }
    protected function _getSession()
    {
        return Mage::getModel('customer/session');
    }
    public function applyGiftCardAction()
    {
        $response = array(
            'status'=> 'error',
            'error' => '',
            'success_message' => ''
        );
        if (!Mage::helper('customer')->isLoggedIn()) {
            $response['error'] = "Please login first to apply Gift Card.";
            echo json_encode($response);
            return;
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
			$response['error'] = "Total Order Amount is already zero.";
			echo json_encode($response);
			return;
			}
		}
		/*------coded by shivaji --------*/

        // retrict user to apply gift of ys with promotion code
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
        {
            $response['error'] = "Cannot apply Gift of YS with Promo code.";
            echo json_encode($response);
            return;
        }
        // retrict user to apply gift of ys with smogi bucks
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $response['error'] = "Cannot apply Gift of YS with Smogi Bucks.";
            echo json_encode($response);
            return;
        }

        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $giftcardCode = trim((string) $this->getRequest()->getParam('giftcard_code'));
        $card = Mage::getModel('giftcards/giftcards')->load($giftcardCode, 'card_code');

        if ($card->getId() && $card->getCardStatus() == 2) {
            $card->activateCardForCustomer($customerId);

            $response['status'] = "success";
            $response['success_message'] = "Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." was applied";

            Mage::getSingleton('giftcards/session')->setActive('1');
            echo json_encode($response);
        } else {
            $response['error'] = "Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." is not valid";
            echo json_encode($response);

        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $this->_getSession()->addError("gferror--msg".$e->getMessage());
            $response['error'] = "Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." is not valid";
            echo json_encode($response);
            return;
        }

    return;

    }

    public function giftcardActiveAction()
    {
        $response = array(
            'status'=> 'error',
            'error' => '',
            'success_message' => ''
        );
        if (!Mage::helper('customer')->isLoggedIn()) {
            $response['error'] = "Please login first to apply Gift Code.";
            Mage::getSingleton('customer/session')->authenticate($this);
            echo json_encode($response);
            return;
        }
		
        if ((string)$this->getRequest()->getParam('giftcard_use') == '1') {
			/*------coded by shivaji --------*/
            // retrict user to apply gift of ys with promotion code
            /*if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
            {
                $response['error'] = "You cannot apply Gift Card with Promo code.";
                echo json_encode($response);
                return;
            }
            // retrict user to apply gift of ys with smogi bucks
            if(Mage::helper('rewardpoints/event')->getCreditPoints() > 0)
            {
                $response['error'] = "Cannot apply Gift of YS with Smogi Bucks.";
                echo json_encode($response);
                return;
            }*/
			/*------coded by shivaji --------*/
			/*------coded by shivaji --------*/
			if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode() || Mage::helper('rewardpoints/event')->getCreditPoints() > 0)
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
					$response['error'] = "Total Order Amount is already zero.";
					echo json_encode($response);
					return;
					}
			}
			/*------coded by shivaji --------*/

            Mage::getSingleton('giftcards/session')->setActive('1');
            $response['status'] = "success";
            $response['success_message'] = "Gift Card Successfully applied.";
        } else {
            $response['status'] = "success";
            $response['success_message'] = "Gift Card Successfully removed.";
            Mage::getSingleton('giftcards/session')->setActive('0');
        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {

            $this->_getSession()->addError($e->getMessage());
            $response['error'] = "There has been an error to apply Gift Card.";
        }
        echo json_encode($response);
        return;
    }
}
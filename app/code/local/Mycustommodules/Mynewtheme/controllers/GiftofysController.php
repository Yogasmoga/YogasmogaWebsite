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
            $response['error'] = "Please login first for apply Gift of YS";
            echo json_encode($response);
            return;
        }
        // retrict user to apply gift of ys with promotion code
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
        {
            $response['error'] = "Cannot apply Gift of YS with Promotion code";
            echo json_encode($response);
            return;
        }
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        $giftcardCode = trim((string) $this->getRequest()->getParam('giftcard_code'));
        $card = Mage::getModel('giftcards/giftcards')->load($giftcardCode, 'card_code');

        if ($card->getId() && $card->getCardStatus() == 2) {
            $card->activateCardForCustomer($customerId);

            $response['status'] = "success";
            $response['success_message'] = "Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)."was applied.";

            Mage::getSingleton('giftcards/session')->setActive('1');
            echo json_encode($response);
        } else {
            $response['error'] = "Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." is not valid.";
            echo json_encode($response);

        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $this->_getSession()->addError("gferror--msg".$e->getMessage());
            $response['error'] = "Gift Card ".Mage::helper('core')->escapeHtml($giftcardCode)." is not valid.";
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
            $response['error'] = "Please login first for apply Gift of YS";
            Mage::getSingleton('customer/session')->authenticate($this);
            echo json_encode($response);
            return;
        }
        if ((string)$this->getRequest()->getParam('giftcard_use') == '1') {

            // retrict user to apply gift of ys with promotion code
            if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
            {
                $response['error'] = "Cannot apply Gift of YS with Promotion code";
                echo json_encode($response);
                return;
            }


            Mage::getSingleton('giftcards/session')->setActive('1');
            $response['status'] = "success";
            $response['success_message'] = "Gift Cart Successfully applied.";
        } else {
            $response['status'] = "success";
            $response['success_message'] = "Gift Cart Successfully removed.";
            Mage::getSingleton('giftcards/session')->setActive('0');
        }
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $response['error'] = "There has been an error to apply Gift of YS.";
        }
        echo json_encode($response);
        return;
    }
}
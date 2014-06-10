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
}
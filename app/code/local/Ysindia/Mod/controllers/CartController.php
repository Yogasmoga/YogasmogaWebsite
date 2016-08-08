<?php
include_once("Mage/Checkout/controllers/CartController.php");
class Ysindia_Mod_CartController extends Mage_Checkout_CartController
{

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


    public function deleteAction()
    {
        /*
                $quote = Mage::getSingleton('checkout/session')->getQuote();
                $cartItems = $quote->getAllVisibleItems();
                $cart = Mage::getSingleton('checkout/cart');

                $id = (int) $this->getRequest()->getParam('id');
                if ($id) {

                    foreach ($cartItems as $item) {
                        if($id == $item->getId()) {

                            $quantity = $item->getQty();

                            if ($quantity > 1) {
                                $item->setQty($quantity-1);
                                $cart->save();
                            } else {
                                try {
                                    $this->_getCart()->removeItem($id)
                                        ->save();
                                } catch (Exception $e) {
                                    $this->_getSession()->addError($this->__('Cannot remove the item.'));
                                    Mage::logException($e);
                                }
                            }
                        }
                    }
                }
        */
//        $this->_redirectReferer(Mage::getUrl('*/*'));


        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItems = $quote->getAllVisibleItems();
        $cart = Mage::getSingleton('checkout/cart');

        $id = (int)$this->getRequest()->getParam('id');
        if ($id) {

            foreach ($cartItems as $item) {

                if ($id == $item->getId()) {

                    $buyRequest = $item->getBuyRequest();

                    // if we are trying to remove gift set
                    if (isset($buyRequest) && isset($buyRequest['type']) && $buyRequest['type'] == "gift") {

                        $giftProductId = $item->getProductId();

                        // remove all child products of this gift
                        foreach ($cartItems as $childItem) {
                            $buyRequest = $childItem->getBuyRequest();

                            if (isset($buyRequest) && isset($buyRequest["type"]) && $buyRequest["type"] == "gift-bundled") {

                                $main_product_id = $buyRequest["main_product_id"];

                                if ($main_product_id === $giftProductId) {
                                    $this->_getCart()->removeItem($childItem->getId())->save();
                                }
                            }
                        }

                        $this->_getCart()->removeItem($id)->save(); // remove the main gift product

                        break;

                    } else {       // for normal products

                        $quantity = $item->getQty();

                        if ($quantity > 1) {
                            $item->setQty($quantity - 1);
                            $cart->save();
                        } else
                            $this->_getCart()->removeItem($id)->save();
                    }
                }
            }
        }

		/****************** Shivaji code, remove all discount ***************/
		Mage::getModel('smogiexpirationnotifier/applyremovediscount')->removesmogibucks();
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode() != ''){
            try{
                $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
                $this->_getQuote()->setCouponCode('')
                    ->collectTotals()
                    ->save();
                // refresh cart total
                $cart = Mage::getSingleton('checkout/session')->getQuote();

                foreach ($cart->getAllAddresses() as $address)
                {
                    $cart->unsetData('cached_items_nonnominal');
                    $cart->unsetData('cached_items_nominal');
                }

                $cart->setTotalsCollectedFlag(false);
                $cart->collectTotals();
            }catch (Exception $e){
                die($e->getMessage());
            }

        }

        Mage::getSingleton('giftcards/session')->setActive('0');
		/****************** Shivaji code, remove all discount ***************/

        $this->_redirectReferer(Mage::getUrl('*/*'));
    }
}
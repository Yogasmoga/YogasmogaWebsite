<?php
include_once("Mage/Checkout/controllers/CartController.php");
class Ysindia_Mod_CartController extends Mage_Checkout_CartController
{
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

        $this->_redirectReferer(Mage::getUrl('*/*'));
    }
}
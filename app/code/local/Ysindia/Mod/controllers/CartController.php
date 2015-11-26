<?php
include_once("Mage/Checkout/controllers/CartController.php");
class Ysindia_Mod_CartController extends Mage_Checkout_CartController
{
    public function deleteAction()
    {
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
        $this->_redirectReferer(Mage::getUrl('*/*'));
    }
}
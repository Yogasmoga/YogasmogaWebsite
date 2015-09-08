<?php

class Ysindia_Customer_Model_Observer
{
    public function checkCart(Varien_Event_Observer $observer){

        $womenBottomCategoryId = 7;
        $womenBottomRangoliCategoryId = 68;
        $womenTopRangoliCategoryId = 67;
        $womenTopCategoryId = 6;

        $cart = $observer->getCart();

        if(isset($cart)) {

            $tops = array();
            $topFound = false;
            $bottomFound = false;
            $topItemIdToUpdate = 0;

            $quote = $cart->getQuote();

            $cartItems = $quote->getAllVisibleItems();

            foreach ($cartItems as $item) {
                /* @var $item Mage_Sales_Model_Quote_Item */

                $product = Mage::getModel('catalog/product')->load($item->getProductId());

                if (isset($product) && $product->isConfigurable()) {

                    $categoryIds = $product->getCategoryIds();

                    Mage::log($product->getSku() . " = " .  implode(',', $categoryIds), null, 'observer.log');

                    if (isset($categoryIds) && count($categoryIds) > 0) {

                        if (in_array($womenBottomCategoryId, $categoryIds) || in_array($womenBottomRangoliCategoryId, $categoryIds)) {              // a bottom is found                            $bottomFound = true;

                            $bottomFound = true;
                        }
                        else if (in_array($womenTopCategoryId, $categoryIds) || in_array($womenTopRangoliCategoryId, $categoryIds)) {

                            $tops[] = array('product' => $product, 'item' => $item);                       // save all tops
                            $topFound = true;
                        }
                    }
                }
            }

            Mage::log("[$topFound] [$bottomFound]", null, 'observer.log');

            if($bottomFound){

                if($topFound) {

                    $first = true;
                    $topProduct = null;
                    foreach ($tops as $top) {

                        if ($first) {
                            $first = false;
                            $topItemIdToUpdate = $top['item']->getSku();
                            $topProduct = $top['product'];

                        } else {

                            $itemProductPrice = $top['product']->getPrice();
                            $topProductPrice = $topProduct->getPrice();

                            Mage::log("[$itemProductPrice] [$topProductPrice]", null, 'observer.log');

                            if ($itemProductPrice < $topProductPrice) {
                                $topItemIdToUpdate = $top['item']->getSku();
                                $topProduct = $top['product'];
                            }

                        }
                    }

                    Mage::log("Item to update [$topItemIdToUpdate]", null, 'observer.log');

                    if (isset($topItemIdToUpdate)) {

                        foreach ($cartItems as $item) {

                            $product = Mage::getModel('catalog/product')->load($item->getProductId());

                            if (isset($product) && $product->isConfigurable()) {

                                Mage::log($item->getSku() . " | " . $topItemIdToUpdate, null, 'observer.log');

                                if ($item->getSku() === $topItemIdToUpdate) {
                                    $item->setCustomPrice(0);
                                    $item->setOriginalCustomPrice(0);
                                    $item->getProduct()->setIsSuperMode(true);
                                }
                                else {
                                    $item->setCustomPrice($product->getPrice());
                                    $item->setOriginalCustomPrice($product->getPrice());
                                    $item->getProduct()->setIsSuperMode(true);
                                }
                            }
                        }
                    }
                }
            }
            else{
                foreach ($cartItems as $item) {

                    $product = Mage::getModel('catalog/product')->load($item->getProductId());

                    if(isset($product) && $product->isConfigurable()) {

                        $item->setCustomPrice($product->getPrice());
                        $item->setOriginalCustomPrice($product->getPrice());
                        $item->getProduct()->setIsSuperMode(true);
                    }
                }
            }
        }
    }
}
<?php

class Ysindia_Customer_Model_Observer
{

    public function itemAdded($observer)
    {
        $item = $observer->getEvent()->getQuoteItem();

        $womenBottomCategoryId = 7;

        $womenTopCategoryId = 6;

        $product = Mage::getModel('catalog/product')->load($item->getProductId());

        $categoryIds = $product->getCategoryIds();

        if (isset($categoryIds) && count($categoryIds) >= 2) {

            if (in_array($womenTopCategoryId, $categoryIds)) {              // a top is added

                $cartItems = Mage::getSingleton('checkout/cart')->getQuote()->getAllItems();

                if (isset($cartItems) && count($cartItems) > 0) {

                    $bottomFound = false;

                    $topWithLowestPrice = null;
                    $topWithLowestPriceProduct = null;

                    // check if there is any bottom in cart
                    foreach ($cartItems as $cartItem) {

                        $cartProduct = Mage::getModel('catalog/product')->load($cartItem->getProductId());

                        $cartProductCategoryIds = $cartProduct->getCategoryIds();

                        if (in_array($womenBottomCategoryId, $cartProductCategoryIds))        // cart have bottom
                            $bottomFound = true;
                        else if (in_array($womenTopCategoryId, $categoryIds)) {

                            if ($topWithLowestPrice == null) {

                                if($cartItem->getPrice()>0) {
                                    $topWithLowestPrice = $cartItem;
                                    $topWithLowestPriceProduct = $cartProduct;
                                }
                            } else {
                                if ($cartProduct->getPrice() < $topWithLowestPriceProduct->getPrice()) {
                                    $topWithLowestPrice = $cartItem;
                                    $topWithLowestPriceProduct = $cartProduct;

                                    $cartItem->setCustomPrice($cartProduct->getPrice());
                                    $cartItem->setOriginalCustomPrice($cartProduct->getPrice());
                                    $cartItem->save();
                                }
                            }
                        }
                    }

                    // since bottom is found, now adjust price of tops
                    if ($bottomFound) {

                        if(isset($topWithLowestPrice)) {
                            $topWithLowestPrice->setCustomPrice(0);
                            $topWithLowestPrice->setOriginalCustomPrice(0);

                            $topWithLowestPrice->save();

                            Mage::log("Lowest top updated = " . $topWithLowestPrice->getName(), null, 'observer.log');
                        }
                    } else {
                        foreach ($cartItems as $cartItem) {
                            $cartProduct = Mage::getModel('catalog/product')->load($cartItem->getProductId());

                            $cartItem->setCustomPrice($cartProduct->getPrice());
                            $cartItem->setOriginalCustomPrice($cartProduct->getPrice());
                            $cartItem->save();
                        }
                    }
                }
            }
            else if (in_array($womenBottomCategoryId, $categoryIds)) {              // a top is added

                $cartItems = Mage::getSingleton('checkout/cart')->getQuote()->getAllItems();

                if (isset($cartItems) && count($cartItems) > 0) {

                    $topWithLowestPrice = null;
                    $topWithLowestPriceProduct = null;

                    // check if there is any bottom in cart
                    foreach ($cartItems as $cartItem) {

                        $cartProduct = Mage::getModel('catalog/product')->load($cartItem->getProductId());

                        $cartProductCategoryIds = $cartProduct->getCategoryIds();

                        if (in_array($womenBottomCategoryId, $cartProductCategoryIds))        // cart have bottom
                            $bottomFound = true;
                        else if (in_array($womenTopCategoryId, $categoryIds)) {

                            if ($topWithLowestPrice == null) {
                                $topWithLowestPrice = $cartItem;
                                $topWithLowestPriceProduct = $cartProduct;
                            } else {
                                if ($cartProduct->getPrice() < $topWithLowestPriceProduct->getPrice()) {
                                    $topWithLowestPrice = $cartItem;
                                    $topWithLowestPriceProduct = $cartProduct;

                                    $cartItem->setCustomPrice($cartProduct->getPrice());
                                    $cartItem->setOriginalCustomPrice($cartProduct->getPrice());
                                    $cartItem->save();
                                }
                            }
                        }
                    }

                    // since bottom is found, now adjust price of tops
                    if ($bottomFound) {

                        if(isset($topWithLowestPrice)) {
                            $topWithLowestPrice->setCustomPrice(0);
                            $topWithLowestPrice->setOriginalCustomPrice(0);

                            $topWithLowestPrice->save();

                            Mage::log("Lowest top updated = " . $topWithLowestPrice->getName(), null, 'observer.log');
                        }
                    } else {
                        foreach ($cartItems as $cartItem) {
                            $cartProduct = Mage::getModel('catalog/product')->load($cartItem->getProductId());

                            $cartItem->setCustomPrice($cartProduct->getPrice());
                            $cartItem->setOriginalCustomPrice($cartProduct->getPrice());
                            $cartItem->save();
                        }
                    }
                }
            }
        }
    }

    public function itemRemoved($observer)
    {
        $womenBottomCategoryId = 7;

        $womenTopCategoryId = 6;

        $cartItems = Mage::getSingleton('checkout/cart')->getQuote()->getAllItems();

        if (isset($cartItems) && count($cartItems) > 0) {

            $bottomFound = false;

            $topWithLowestPrice = null;
            $topWithLowestPriceProduct = null;

            // check if there is any bottom in cart
            foreach ($cartItems as $cartItem) {

                $cartProduct = Mage::getModel('catalog/product')->load($cartItem->getProductId());

                $cartProductCategoryIds = $cartProduct->getCategoryIds();

                if (in_array($womenBottomCategoryId, $cartProductCategoryIds))        // cart have bottom
                    $bottomFound = true;
                else if (in_array($womenTopCategoryId, $cartProductCategoryIds)) {

                    if ($topWithLowestPrice == null) {
                        $topWithLowestPrice = $cartItem;
                        $topWithLowestPriceProduct = $cartProduct;
                    } else {
                        if ($cartProduct->getPrice() < $topWithLowestPriceProduct->getPrice()) {
                            $topWithLowestPrice = $cartItem;
                            $topWithLowestPriceProduct = $cartProduct;

                            $cartItem->setCustomPrice($cartProduct->getPrice());
                            $cartItem->setOriginalCustomPrice($cartProduct->getPrice());
                            $cartItem->save();
                        }
                    }
                }
            }

            // since bottom is found, now adjust price of tops
            if ($bottomFound) {

                $topWithLowestPrice->setCustomPrice(0);
                $topWithLowestPrice->setOriginalCustomPrice(0);

                $topWithLowestPrice->save();

                Mage::log("Lowest top updated = " . $topWithLowestPrice->getName(), null, 'observer.log');
            } else {
                foreach ($cartItems as $cartItem) {
                    $cartProduct = Mage::getModel('catalog/product')->load($cartItem->getProductId());

                    $cartItem->setCustomPrice($cartProduct->getPrice());
                    $cartItem->setOriginalCustomPrice($cartProduct->getPrice());
                    $cartItem->save();
                }
            }
        }
    }
}
<?php

class Ysindia_Customer_Model_Observer
{
    public function checkCart(Varien_Event_Observer $observer){

        $womenBottomCategoryId = 7;
        $oneToManyWomenCategory = 52;
        $womenTopCategoryId = 6;

        $cart = $observer->getCart();

        if(isset($cart)) {

            $tops = array();
            $topFound = false;
            $bottomFound = false;
            $topItemIdToUpdate = 0;

            $quote = $cart->getQuote();

            $cartItems = $quote->getAllVisibleItems();

            foreach ($cartItems as $item) { /* @var $item Mage_Sales_Model_Quote_Item */

                $product = Mage::getModel('catalog/product')->load($item->getProductId());

                if (isset($product) && $product->isConfigurable()) {

                    $categoryIds = $product->getCategoryIds();

                    if (isset($categoryIds) && count($categoryIds) >= 2) {

                        if (in_array($womenBottomCategoryId, $categoryIds)) {              // a bottom is found                            $bottomFound = true;

                            if(!$bottomFound){

                                $simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku());

                                $simpleCategoryIds = $simpleProduct->getCategoryIds();

                                if(!in_array($oneToManyWomenCategory, $simpleCategoryIds)){
                                    $bottomFound = true;
                                }
                            }
                        }
                        else if (in_array($womenTopCategoryId, $categoryIds)) {

                            $tops[] = array('product' => $product, 'item' => $item);                       // save all tops
                            $topFound = true;
                        }
                    }
                }
            }

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

                            $item = $top['item'];
                            $itemProduct = $top['product'];

                            $productBySkuTemp = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku());
                            $topProductBySkuTemp = Mage::getModel('catalog/product')->loadByAttribute('sku', $topItemIdToUpdate);

                            $categoriesItemProduct = $productBySkuTemp->getCategoryIds();
                            $categoriesTopProduct = $topProductBySkuTemp->getCategoryIds();

                            $itemProductPrice = $itemProduct->getPrice();
                            $topProductPrice = $topProduct->getPrice();

                            /***************** check if product is from one to many, then read simple product price ********************/
                            if (in_array($oneToManyWomenCategory, $categoriesItemProduct))
                                $itemProductPrice = $productBySkuTemp->getPrice();

                            if (in_array($oneToManyWomenCategory, $categoriesTopProduct))
                                $topProductPrice = $topProductBySkuTemp->getPrice();
                            /***************** check if product is from one to many, then read simple product price ********************/

                            Mage::log($productBySkuTemp->getSku() .  ' = ' . count($categoriesItemProduct), null, 'observer.log');
                            Mage::log($topProductBySkuTemp->getSku() .  ' = ' . count($categoriesTopProduct), null, 'observer.log');

                            Mage::log($productBySkuTemp->getSku() .  ' <item> = ' . $itemProductPrice . ' , ' . $topProductBySkuTemp->getSku()  . ' <top> = ' . $topProductPrice, null, 'observer.log');

                            if (isset($top['product']) && isset($topProduct) && ($itemProductPrice < $topProductPrice)) {
                                $topItemIdToUpdate = $top['item']->getSku();
                                $topProduct = $top['product'];
                            }

                        }
                    }

                    if (isset($topItemIdToUpdate)) {

                        foreach ($cartItems as $item) {

                            $product = Mage::getModel('catalog/product')->load($item->getProductId());

                            if ($product->isConfigurable()) {

                                $productBySku = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku());

                                if(isset($productBySku)) {

                                    if ($productBySku->getSku() === $topItemIdToUpdate) {

                                        $item->setCustomPrice(0);
                                        $item->setOriginalCustomPrice(0);
                                        $item->getProduct()->setIsSuperMode(true);
                                    } else {

                                        $categoryIds = $productBySku->getCategoryIds();

                                        if (in_array($oneToManyWomenCategory, $categoryIds)) {
                                            $item->setCustomPrice($productBySku->getPrice());
                                            $item->setOriginalCustomPrice($productBySku->getPrice());
                                            $item->getProduct()->setIsSuperMode(true);
                                        }
                                        else{
                                            $item->setCustomPrice($product->getPrice());
                                            $item->setOriginalCustomPrice($product->getPrice());
                                            $item->getProduct()->setIsSuperMode(true);
                                        }

                                    }
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

                        $productBySku = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku());

                        $categoryIds = $productBySku->getCategoryIds();

                        if (in_array($oneToManyWomenCategory, $categoryIds)) {
                            $item->setCustomPrice($productBySku->getPrice());
                            $item->setOriginalCustomPrice($productBySku->getPrice());
                            $item->getProduct()->setIsSuperMode(true);
                        }
                        else{
                            $item->setCustomPrice($product->getPrice());
                            $item->setOriginalCustomPrice($product->getPrice());
                            $item->getProduct()->setIsSuperMode(true);
                        }
                    }
                }
            }
        }
    }
}
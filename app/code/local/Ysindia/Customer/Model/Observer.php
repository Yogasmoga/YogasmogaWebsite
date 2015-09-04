<?php

class Ysindia_Customer_Model_Observer
{
    public function checkCart(Varien_Event_Observer $observer){

        $womenBottomCategoryId = 7;

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

                    $product = Mage::getModel('catalog/product')->load($item->getProductId());

                    $categoryIds = $product->getCategoryIds();

                    if (isset($categoryIds) && count($categoryIds) >= 2) {

                        if (in_array($womenBottomCategoryId, $categoryIds)) {              // a bottom is found
                            $bottomFound = true;
                            Mage::log('Bottom found set', null, 'observer.log');
                        }
                        else if (in_array($womenTopCategoryId, $categoryIds)) {
                            Mage::log('Stored item with id = ' . $item->getProductId(), null, 'observer.log');
                            $tops[] = array('product' => $product, 'item' => $item);                       // save all tops
                            $topFound = true;
                            Mage::log('Top found', null, 'observer.log');
                        }
                    }
                }
            }

            if($bottomFound){

                if($topFound){

                    Mage::log('Total tops = ' . count($tops), null, 'observer.log');

                    $first = true;
                    $topProduct = null;
                    foreach($tops as $top){

                        if($first){
                            $first = false;
                            $topItemIdToUpdate = $top['item']->getProductId();
                            $topProduct = $top['product'];

                            Mage::log('First top initialized as smallest with price = ' . $topProduct->getPrice(), null, 'observer.log');
                        }
                        else{

                            if(isset($top['product']) && isset($topProduct) && ($top['product']->getPrice()<$topProduct->getPrice())){
                                $topItemIdToUpdate = $top['item']->getProductId();
                                $topProduct = $top['product'];

                                Mage::log('New top found with smaller price', null, 'observer.log');
                            }
                        }
                    }

                    Mage::log('Item to update found ' . $topItemIdToUpdate . '(' . isset($topItemIdToUpdate) . ')', null, 'observer.log');

                    if(isset($topItemIdToUpdate)) {

                        foreach ($cartItems as $item) {

                            $product = Mage::getModel('catalog/product')->load($item->getProductId());

                            Mage::log('** ' . $product->isConfigurable() . ', *' . $product->getId() . ' ,  ' . $topItemIdToUpdate . '*' .($product->getId() === $topItemIdToUpdate) . ']' , null , 'observer.log');

                            if ($product->isConfigurable() && ($product->getId() === $topItemIdToUpdate)) {

                                Mage::log('Item to update found ' . $topItemIdToUpdate, null, 'observer.log');

                                $item->setCustomPrice(0);
                                $item->setOriginalCustomPrice(0);
                                $item->getProduct()->setIsSuperMode(true);
                            }
                            else {


                                if(isset($product)) {
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

                    if(isset($product)) {
                        $item->setCustomPrice($product->getPrice());
                        $item->setOriginalCustomPrice($product->getPrice());
                        $item->getProduct()->setIsSuperMode(true);
                    }
                }
            }
        }
    }
}
<?php

class Ysindia_Customer_Model_Observer
{
    public function checkTopFreeWithBottom(Varien_Event_Observer $observer){

        $womenBottomCategoryId = 7;
        $womenBottomRangoliCategoryId = 70;
        $womenTopRangoliCategoryId = 69;
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

    public function checkTopBottom75DollarOff(Varien_Event_Observer $observer){

        $womenBottomCategoryId = 7;
        $womenBottomRangoliCategoryId = 68;
        $womenTopRangoliCategoryId = 67;
		$onetomanycopy = 52;
        $womenTopCategoryId = 6;

        $discountAmount = 75;
        $bottomCount = 0;
        $topCount = 0;

        $quote = $observer->getEvent()->getQuote();
		
		
		$cartItems = $quote->getAllVisibleItems();

            foreach ($cartItems as $item) {
			
                $product = Mage::getModel('catalog/product')->load($item->getProductId());

                if (isset($product) && $product->isConfigurable()) {

                    $categoryIds = $product->getCategoryIds();
				
					Mage::log("category ids: ".print_r($categoryIds,true), null, 'confcat.log');
				if (isset($categoryIds) && count($categoryIds) > 0) {
					
					$simpleProduct = Mage::getModel('catalog/product')->loadByAttribute('sku',$item->getSku());
					$simpleCategories = $simpleProduct->getCategoryIds();	
						Mage::log("Simple category ids: ".print_r($simpleCategories,true), null, 'Simcat.log');
						if(in_array($onetomany, $simpleCategories))
							;		
                        else if (in_array($womenBottomCategoryId, $categoryIds) || in_array($womenBottomRangoliCategoryId, $categoryIds)) {

                            $bottomCount++;
							
                        }
                        else if (in_array($womenTopCategoryId, $categoryIds) || in_array($womenTopRangoliCategoryId, $categoryIds)) {

                            $topCount++;
							
                        }
                    }
                }
            }
			//Mage::log("bottom found: ".$bottomCount."top found: ".$topCount, null, 'disc.log');
            if($bottomCount>0 && $topCount>0){
				
                $discountCount = $bottomCount < $topCount ? $bottomCount : $topCount;

                $totalDiscount = $discountAmount * $discountCount;

                $this->setDiscount($observer, $totalDiscount);
            }
        
    }

    public function setDiscount($observer,$discountAmount)
    {
        $quote=$observer->getEvent()->getQuote();
		$quoteid=$quote->getId();
		
			if($quoteid) {
				if($discountAmount>0) {
					$total=$quote->getBaseSubtotal();
					$quote->setSubtotal(0);
					$quote->setBaseSubtotal(0);
					$quote->setSubtotalWithDiscount(0);
					$quote->setBaseSubtotalWithDiscount(0);
					$quote->setGrandTotal(0);
					$quote->setBaseGrandTotal(0);
			
			$canAddItems = $quote->isVirtual()? ('billing') : ('shipping'); 
			foreach ($quote->getAllAddresses() as $address) {
				$address->setSubtotal(0);
				$address->setBaseSubtotal(0);
				$address->setGrandTotal(0);
				$address->setBaseGrandTotal(0);
				$address->collectTotals();
				$quote->setSubtotal((float) $quote->getSubtotal() + $address->getSubtotal());
				$quote->setBaseSubtotal((float) $quote->getBaseSubtotal() + $address->getBaseSubtotal());
				$quote->setSubtotalWithDiscount(
					(float) $quote->getSubtotalWithDiscount() + $address->getSubtotalWithDiscount()
				);
            $quote->setBaseSubtotalWithDiscount(
                (float) $quote->getBaseSubtotalWithDiscount() + $address->getBaseSubtotalWithDiscount()
            );

            $quote->setGrandTotal((float) $quote->getGrandTotal() + $address->getGrandTotal());
            $quote->setBaseGrandTotal((float) $quote->getBaseGrandTotal() + $address->getBaseGrandTotal());
 
			$quote ->save(); 
 
		  $quote->setGrandTotal($quote->getBaseSubtotal()-$discountAmount)
		  ->setBaseGrandTotal($quote->getBaseSubtotal()-$discountAmount)
		  ->setSubtotalWithDiscount($quote->getBaseSubtotal()-$discountAmount)
		  ->setBaseSubtotalWithDiscount($quote->getBaseSubtotal()-$discountAmount)
		  ->save(); 
      
    
			if($address->getAddressType()==$canAddItems) {
				//echo $address->setDiscountAmount; exit;
				 $address->setSubtotalWithDiscount((float) $address->getSubtotalWithDiscount()-$discountAmount);
				 $address->setGrandTotal((float) $address->getGrandTotal()-$discountAmount);
				 $address->setBaseSubtotalWithDiscount((float) $address->getBaseSubtotalWithDiscount()-$discountAmount);
				 $address->setBaseGrandTotal((float) $address->getBaseGrandTotal()-$discountAmount);
				 if($address->getDiscountDescription()){
				 $address->setDiscountAmount(-($address->getDiscountAmount()-$discountAmount));
				 $address->setDiscountDescription($address->getDiscountDescription().', Custom Discount');
				 $address->setBaseDiscountAmount(-($address->getBaseDiscountAmount()-$discountAmount));
				 }else {
				 $address->setDiscountAmount(-($discountAmount));
				 $address->setDiscountDescription('Custom Discount');
				 $address->setBaseDiscountAmount(-($discountAmount));
				}
			 $address->save();
			}
		} 
   
  
		foreach($quote->getAllItems() as $item){
				 //We apply discount amount based on the ratio between the GrandTotal and the RowTotal
				 $rat=$item->getPriceInclTax()/$total;
				 $ratdisc=$discountAmount*$rat;
				 $item->setDiscountAmount(($item->getDiscountAmount()+$ratdisc) * $item->getQty());
				 $item->setBaseDiscountAmount(($item->getBaseDiscountAmount()+$ratdisc) * $item->getQty())->save();
				
				}
            }
        }
    }
}
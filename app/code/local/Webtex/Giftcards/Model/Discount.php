<?php

class Webtex_Giftcards_Model_Discount extends Mage_SalesRule_Model_Quote_Discount
{
    /**
     * Collect gift card discount amount
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_SalesRule_Model_Quote_Discount
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        /* Apply standard sales rules */
        parent::collect($address);

        $address->getQuote()->setUseGiftcards(false);
        if ($this->getGiftcardDiscountEnabled()) {
            $giftcardBalance = Mage::app()->getStore($address->getQuote()->getStoreId())->convertPrice($this->getAvailableGiftCardBalance());
            $baseGiftcardBalance = $this->getAvailableGiftCardBalance();

            /*Check if need to add shipping to giftcard*/
            if(Mage::getStoreConfig('giftcards/default/card_apply_to_shipping'))
            {
                $shippingAmount     = $address->getShippingAmountForDiscount();
                if ($shippingAmount!==null) {
                    $baseShippingAmount = $address->getBaseShippingAmountForDiscount();
                } else {
                    $shippingAmount     = $address->getShippingAmount() ? $address->getShippingAmount() : 0;
                    $baseShippingAmount = $address->getBaseShippingAmount() ? $address->getShippingAmount() : 0;
                }

                //post process shipping amount
                $baseShippingAmount = ($baseGiftcardBalance - $baseShippingAmount) > 0 ? $baseShippingAmount : 0;
                $shippingAmount = ($giftcardBalance - $shippingAmount > 0) ? $shippingAmount : 0;
            }
            else
            {
                $shippingAmount = 0;
                $baseShippingAmount = 0;
            }

            /* Calculate discount */
            $this->_collectSubtotals($address);

            /* Apply discount to items */
            $items = $this->_getAddressItems($address);

            $giftDiscountBalance = $baseGiftcardBalance - $baseShippingAmount;
            $wholeDiscount = 0;
            $wholeBaseDiscount = 0;

            foreach ($items as $item) {
                //Skipping child items to avoid double calculations
                if ($item->getParentItemId()) {
                    continue;
                }
                $quote = $item->getQuote();
                $basePrice = ($item->getDiscountCalculationPrice() !== null) ? $item->getBaseDiscountCalculationPrice() : $item->getBaseCalculationPrice();
                $price = ($item->getDiscountCalculationPrice() !== null) ? $item->getDiscountCalculationPrice() : $item->getCalculationPrice();

                $itemDiscountAmount = $item->getDiscountAmount() >0 ? $item->getDiscountAmount() : 0;
                $itemBaseDiscountAmount = $item->getBaseDiscountAmount() > 0 ? $item->getBaseDiscountAmount() : 0;

                $discountAmount = min($giftDiscountBalance, ($price * $item->getTotalQty() - $itemDiscountAmount ));
                $discountAmount = $quote->getStore()->roundPrice($discountAmount);
                $baseDiscountAmount = min(($basePrice * $item->getTotalQty() - $itemBaseDiscountAmount), $giftDiscountBalance);
                $baseDiscountAmount = $quote->getStore()->roundPrice($baseDiscountAmount);

                $item->setDiscountAmount($itemDiscountAmount + $discountAmount);
                $item->setBaseDiscountAmount($itemBaseDiscountAmount + $baseDiscountAmount);

                $giftDiscountBalance -= $baseDiscountAmount;
                $wholeDiscount += $discountAmount;
                $wholeBaseDiscount += $baseDiscountAmount;
            }

            /* Apply discount */
            $baseGiftcardsDiscount = $wholeBaseDiscount + $baseShippingAmount;
            $giftCardsDiscount = $wholeDiscount + $shippingAmount;
            $this->_addAmount(-$giftCardsDiscount);
            $this->_addBaseAmount(-$baseGiftcardsDiscount);

            $address->setBaseShippingDiscountAmount($baseShippingAmount);
            $address->setShippingDiscountAmount($shippingAmount);

            /* Append giftcard description */
            $descriptions = $address->getDiscountDescriptionArray();
            $descriptions[] = 'Gift Card';
            $address->setDiscountDescriptionArray($descriptions);
            $this->_calculator->prepareDescription($address);

            /* Save gift discount params */
            if($baseGiftcardsDiscount > 0) {
                $address->getQuote()->setUseGiftcards(true);
                $address->getQuote()->setGiftcardsDiscount($baseGiftcardsDiscount);
            }
        }

        return $this;
    }

    protected function _collectSubtotals(Mage_Sales_Model_Quote_Address $address)
    {
        $totalItems = 0;
        $totalItemsPrice = 0;
        $totalBaseItemsPrice = 0;
        $items = $this->_getAddressItems($address);
        foreach ($items as $item) {
            //Skipping child items to avoid double calculations
            if ($item->getParentItemId()) {
                continue;
            }
            $qty = $item->getTotalQty();
            $price = ($item->getDiscountCalculationPrice() !== null) ? $item->getDiscountCalculationPrice() : $item->getCalculationPrice();
            $basePrice = ($item->getDiscountCalculationPrice() !== null) ? $item->getBaseDiscountCalculationPrice() : $item->getBaseCalculationPrice();
            $totalItemsPrice += $price * $qty;
            $totalBaseItemsPrice += $basePrice * $qty;
            $totalItems++;
        }
        $this->_subtotals = array(
            'items_count' => $totalItems,
            'items_price' => $totalItemsPrice,
            'base_items_price' => $totalBaseItemsPrice,
        );
    }

    protected function _getSubtotal()
    {
        return $this->_subtotals['items_price'];
    }

    protected function _getBaseSubtotal()
    {
        return $this->_subtotals['base_items_price'];
    }

    protected function getGiftcardDiscountEnabled()
    {
        return (Mage::getSingleton('giftcards/session')->getActive() == '1');
    }

    protected function getAvailableGiftCardBalance()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            $customerId = Mage::getSingleton('adminhtml/session_quote')->getCustomerId();
        }else{
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        }

        //return Mage::helper('giftcards')->getCustomerBalance($customerId);
		/*********** Coded By Shivaji Chauhan **********/
        $balance = Mage::helper('giftcards')->getCustomerBalance($customerId);
		
		//code for smogi points if applied
		$creditpointsentered = Mage::helper('rewardpoints/event')->getCreditPoints();
		if($creditpointsentered > 0){
		$cart = Mage::getSingleton('checkout/session');
		$totals = $cart->getQuote()->getTotals(); //Total object
		$subtotal = $totals["subtotal"]->getValue();

		/************Shippping****************/
		$shippingPrice = 0;
		$shippingPrice = (int)Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->getShippingAmount();
		/************Shippping****************/

		$points = (int)$this->getPointsCurrentlyUsed() * -1;
		$applicablesmogibucks = $subtotal - $points;
		//new code
		if(isset($points) && is_numeric($points) && $points > 0  && $creditpointsentered > $applicablesmogibucks){
		$creditpointsentered = (int)$applicablesmogibucks;
		}
		if(isset($shippingPrice) && is_numeric($shippingPrice) && $shippingPrice > 0  && $creditpointsentered > $applicablesmogibucks){
		$creditpointsentered = (int)$applicablesmogibucks;
		}
		//new code

		
		/************Shippping****************/
		$subtotal = $subtotal + (int)$shippingPrice;
		/************Shippping****************/
		$total = $subtotal - $creditpointsentered;
		$balance = ($total <= $balance ? $total : $balance);
		//Mage::log("Balance = $balance, subtotal = $subtotal, Smogi = $creditpointsentered, points = $points, applicable = $applicablesmogibucks", null, "smogi.log");
		$flag = 0;
		if($balance <= 0 && $subtotal == $applicablesmogibucks && $creditpointsentered >= $applicablesmogibucks){
			$flag = 1;
		}
		if($balance == 0 || $flag == 1)
			Mage::getSingleton('giftcards/session')->setActive('0');
		}
		//code for smogi points if applied
		
		return $balance;
		/*********** Coded By Shivaji Chauhan **********/
    }


	public function getPointsCurrentlyUsed() {
        $creditpointsentered = Mage::helper('rewardpoints/event')->getCreditPoints();
        $grandTotal = Mage::helper('checkout/cart')->getQuote()->getSubtotal();
        //print_r($grandTotal);
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $cartHelper = Mage::helper('checkout/cart');
        $items = $cartHelper->getCart()->getItems();
        $itemids = array();
        $count = 0;
		$cattotal = 0;

        foreach ($items as $item) {
            array_push($itemids, $item->getProductId());
        }

        foreach ($items as $item) {

            if($item->getPrice() > 0)
            {
                $itemId = $item->getProductId();
                $itemstotal = $item->getRowTotal();

                if($item->getProductType() == "configurable")
                {$query1 = "Select category_id, name from catalog_category_product, catalog_category_flat_store_1 where catalog_category_product.product_id IN (".$itemId.",".$itemids[$count + 1].") and catalog_category_flat_store_1.entity_id = catalog_category_product.category_id";

                }
                else
                    $query1 = "Select category_id, name from catalog_category_product, catalog_category_flat_store_1 where catalog_category_product.product_id = ".$itemId." and catalog_category_flat_store_1.entity_id = catalog_category_product.category_id";
                $categoryid = $readConnection->fetchAll($query1);
                $excludecats = Mage::getModel('core/variable')->loadByCode('nosmogicategories')->getValue('plain');
                $excludecats = explode(",", $excludecats);

                for($id=0;$id<count($categoryid);$id++)
                {
                    $flag = false;
                    for($i = 0; $i < count($excludecats); $i++)
                    {
                        if($categoryid[$id]['category_id'] == $excludecats[$i])
                        {
                            $flag = true;
                            break;
                        }
                    }
                    if($flag)
                    {
                        $cattotal = $cattotal + $itemstotal;
						break;
                    }
                }
				//check no discount
				if ($product = $item->getProduct()) {
                    if ($product->getData('reward_no_discount')) {
                        $cattotal = $cattotal + $itemstotal;
                    }
                }
			//Mage::log("Balance No Smogi = $cattotal", null, "smogi.log");
            }
            $count++;
        }

        $grandTotal = $grandTotal - $cattotal;
		

        if ($creditpointsentered > $grandTotal)
        {
            //Mage::getSingleton('core/session')->setCreditPointsApplied($grandTotal);
            //echo $grandTotal;
            return $grandTotal;
        }
        else
        {
            //echo $creditpointsentered;
            return $creditpointsentered;
        }

    }

	

}

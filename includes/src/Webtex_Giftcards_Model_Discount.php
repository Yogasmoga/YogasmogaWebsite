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

        return Mage::helper('giftcards')->getCustomerBalance($customerId);
    }

}

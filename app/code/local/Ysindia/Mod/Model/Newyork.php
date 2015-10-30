<?php
class Ysindia_Mod_Model_Newyork extends Mage_Tax_Model_Sales_Total_Quote_Subtotal
{
    protected function _rowBaseCalculation($item, $request)
    {
        // If USD and from NY Region, apply tax rate based on grand total
     /*   if(Mage::app()->getStore()->getCurrentCurrencyCode() == "USD" && $request['region_id'] == "43") {
            $price_minus_discount = $item['price'];// - $item['discount_amount'];
            if($price_minus_discount < 110) {
               $item->getProduct()->setTaxClassId('30');
            }
        }
	*/
        $request->setProductClassId($item->getProduct()->getTaxClassId());
        $rate   = $this->_calculator->getRate($request);

        $qty    = $item->getTotalQty();

        $price          = $taxPrice         = $item->getCalculationPriceOriginal();
        $basePrice      = $baseTaxPrice     = $item->getBaseCalculationPriceOriginal();
        $subtotal       = $taxSubtotal      = $item->getRowTotal();
        $baseSubtotal   = $baseTaxSubtotal  = $item->getBaseRowTotal();
        $taxOnOrigPrice = !$this->_helper->applyTaxOnCustomPrice($this->_store) && $item->hasCustomPrice();
        if ($taxOnOrigPrice) {
            $origSubtotal       = $item->getOriginalPrice() * $qty;
            $baseOrigSubtotal   = $item->getBaseOriginalPrice() * $qty;
        }

        $item->setTaxPercent($rate);
        if ($this->_config->priceIncludesTax($this->_store)) {
            if ($this->_sameRateAsStore($request)) {
                $rowTax         = $this->_calculator->calcTaxAmount($subtotal, $rate, true, false);
                $baseRowTax     = $this->_calculator->calcTaxAmount($baseSubtotal, $rate, true, false);
                $taxPrice       = $price;
                $baseTaxPrice   = $basePrice;
                $taxSubtotal    = $subtotal;
                $baseTaxSubtotal= $baseSubtotal;
                $subtotal       = $this->_calculator->round($subtotal - $rowTax);
                $baseSubtotal   = $this->_calculator->round($baseSubtotal - $baseRowTax);
                $price          = $this->_calculator->round($subtotal/$qty);
                $basePrice      = $this->_calculator->round($baseSubtotal/$qty);
                if ($taxOnOrigPrice) {
                    $taxable        = $origSubtotal;
                    $baseTaxable    = $baseOrigSubtotal;
                } else {
                    $taxable        = $taxSubtotal;
                    $baseTaxable    = $baseTaxSubtotal;
                }
                $isPriceInclTax = true;
            } else {
                $storeRate      = $this->_calculator->getStoreRate($request, $this->_store);
                $storeTax       = $this->_calculator->calcTaxAmount($subtotal, $storeRate, true, false);
                $baseStoreTax   = $this->_calculator->calcTaxAmount($baseSubtotal, $storeRate, true, false);
                $subtotal       = $this->_calculator->round($subtotal - $storeTax);
                $baseSubtotal   = $this->_calculator->round($baseSubtotal - $baseStoreTax);
                $price          = $this->_calculator->round($subtotal/$qty);
                $basePrice      = $this->_calculator->round($baseSubtotal/$qty);

                $rowTax         = $this->_calculator->calcTaxAmount($subtotal, $rate, false, false);
                $baseRowTax     = $this->_calculator->calcTaxAmount($baseSubtotal, $rate, false, false);
                $taxSubtotal    = $subtotal + $rowTax;
                $baseTaxSubtotal= $baseSubtotal + $baseRowTax;
                $taxPrice       = $this->_calculator->round($taxSubtotal/$qty);
                $baseTaxPrice   = $this->_calculator->round($baseTaxSubtotal/$qty);
                if ($taxOnOrigPrice) {
                    $taxable        = $this->_calculator->round($origSubtotal - $storeTax);
                    $baseTaxable    = $this->_calculator->round($baseOrigSubtotal - $baseStoreTax);
                } else {
                    $taxable        = $subtotal;
                    $baseTaxable    = $baseSubtotal;
                }
                $isPriceInclTax = false;
            }
        } else {
            $rowTax     = $this->_calculator->calcTaxAmount($subtotal, $rate, false, false);
            $baseRowTax = $this->_calculator->calcTaxAmount($baseSubtotal, $rate, false, false);
            $taxSubtotal    = $subtotal + $rowTax;
            $baseTaxSubtotal= $baseSubtotal + $baseRowTax;
            $taxPrice       = $this->_calculator->round($taxSubtotal/$qty);
            $baseTaxPrice   = $this->_calculator->round($baseTaxSubtotal/$qty);
            if ($taxOnOrigPrice) {
                $taxable        = $origSubtotal;
                $baseTaxable    = $baseOrigSubtotal;
            } else {
                $taxable        = $subtotal;
                $baseTaxable    = $baseSubtotal;
            }
            $isPriceInclTax = false;
        }

        if ($item->hasCustomPrice()) {
            /**
             * Initialize item original price before declaring custom price
             */
            $item->getOriginalPrice();
            $item->setCustomPrice($price);
            $item->setBaseCustomPrice($basePrice);
        }
        $item->setPrice($basePrice);
        $item->setBasePrice($basePrice);
        $item->setRowTotal($subtotal);
        $item->setBaseRowTotal($baseSubtotal);
        $item->setPriceInclTax($taxPrice);
        $item->setBasePriceInclTax($baseTaxPrice);
        $item->setRowTotalInclTax($taxSubtotal);
        $item->setBaseRowTotalInclTax($baseTaxSubtotal);
        $item->setTaxableAmount($taxable);
        $item->setBaseTaxableAmount($baseTaxable);
        $item->setIsPriceInclTax($isPriceInclTax);
        if ($this->_config->discountTax($this->_store)) {
            $item->setDiscountCalculationPrice($taxSubtotal/$qty);
            $item->setBaseDiscountCalculationPrice($baseTaxSubtotal/$qty);
        } elseif ($isPriceInclTax) {
            $item->setDiscountCalculationPrice($subtotal/$qty);
            $item->setBaseDiscountCalculationPrice($baseSubtotal/$qty);
        }

        return $this;
    }

    protected function _unitBaseCalculation($item, $request)
    {
	
		 $request->setProductClassId($item->getProduct()->getTaxClassId());
        $rate   = $this->_calculator->getRate($request);

        if(Mage::app()->getStore()->getCurrentCurrencyCode() == "USD" && $request['region_id'] == "43") {
            $price_minus_discount = $item['price'];// - $item['discount_amount'];
            if($price_minus_discount < 110) {
                $rate = 0;
            }
        }
	
        
        $qty    = $item->getTotalQty();

        $price          = $taxPrice         = $item->getCalculationPriceOriginal();
        $basePrice      = $baseTaxPrice     = $item->getBaseCalculationPriceOriginal();
        $subtotal       = $taxSubtotal      = $item->getRowTotal();
        $baseSubtotal   = $baseTaxSubtotal  = $item->getBaseRowTotal();
        $taxOnOrigPrice = !$this->_helper->applyTaxOnCustomPrice($this->_store) && $item->hasCustomPrice();
        if ($taxOnOrigPrice) {
            $origPrice       = $item->getOriginalPrice();
            $baseOrigPrice   = $item->getBaseOriginalPrice();
        }


        $item->setTaxPercent($rate);
        if ($this->_config->priceIncludesTax($this->_store)) {
            if ($this->_sameRateAsStore($request)) {
                $tax            = $this->_calculator->calcTaxAmount($price, $rate, true);
                $baseTax        = $this->_calculator->calcTaxAmount($basePrice, $rate, true);
                $taxPrice       = $price;
                $baseTaxPrice   = $basePrice;
                $taxSubtotal    = $subtotal;
                $baseTaxSubtotal= $baseSubtotal;
                $price          = $price - $tax;
                $basePrice      = $basePrice - $baseTax;
                $subtotal       = $price * $qty;
                $baseSubtotal   = $basePrice * $qty;
                if ($taxOnOrigPrice) {
                    $taxable        = $origPrice;
                    $baseTaxable    = $baseOrigPrice;
                } else {
                    $taxable        = $taxPrice;
                    $baseTaxable    = $baseTaxPrice;
                }
                $isPriceInclTax = true;
            } else {
                $storeRate      = $this->_calculator->getStoreRate($request, $this->_store);
                $storeTax       = $this->_calculator->calcTaxAmount($price, $storeRate, true);
                $baseStoreTax   = $this->_calculator->calcTaxAmount($basePrice, $storeRate, true);
                $price          = $price - $storeTax;
                $basePrice      = $basePrice - $baseStoreTax;
                $subtotal       = $price * $qty;
                $baseSubtotal   = $basePrice * $qty;

                $tax            = $this->_calculator->calcTaxAmount($price, $rate, false);
                $baseTax        = $this->_calculator->calcTaxAmount($basePrice, $rate, false);
                $taxPrice       = $price + $tax;
                $baseTaxPrice   = $basePrice + $baseTax;
                $taxSubtotal    = $taxPrice * $qty;
                $baseTaxSubtotal= $baseTaxPrice * $qty;
                if ($taxOnOrigPrice) {
                    $taxable        = $origPrice - $storeTax;
                    $baseTaxable    = $baseOrigPrice - $baseStoreTax;
                } else {
                    $taxable        = $price;
                    $baseTaxable    = $basePrice;
                }
                $isPriceInclTax = false;
            }
        } else {
            $tax            = $this->_calculator->calcTaxAmount($price, $rate, false);
            $baseTax        = $this->_calculator->calcTaxAmount($basePrice, $rate, false);
            $taxPrice       = $price + $tax;
            $baseTaxPrice   = $basePrice + $baseTax;
            $taxSubtotal    = $taxPrice * $qty;
            $baseTaxSubtotal= $baseTaxPrice * $qty;
            if ($taxOnOrigPrice) {
                $taxable        = $origPrice;
                $baseTaxable    = $baseOrigPrice;
            } else {
                $taxable        = $price;
                $baseTaxable    = $basePrice;
            }
            $isPriceInclTax = false;
        }

        if ($item->hasCustomPrice()) {
            /**
             * Initialize item original price before declaring custom price
             */
            $item->getOriginalPrice();
            $item->setCustomPrice($price);
            $item->setBaseCustomPrice($basePrice);
        }
        $item->setPrice($basePrice);
        $item->setBasePrice($basePrice);
        $item->setRowTotal($subtotal);
        $item->setBaseRowTotal($baseSubtotal);
        $item->setPriceInclTax($taxPrice);
        $item->setBasePriceInclTax($baseTaxPrice);
        $item->setRowTotalInclTax($taxSubtotal);
        $item->setBaseRowTotalInclTax($baseTaxSubtotal);
        $item->setTaxableAmount($taxable);
        $item->setBaseTaxableAmount($baseTaxable);
        $item->setIsPriceInclTax($isPriceInclTax);
        if ($this->_config->discountTax($this->_store)) {
            $item->setDiscountCalculationPrice($taxPrice);
            $item->setBaseDiscountCalculationPrice($baseTaxPrice);
        }
        return $this;
    }
}

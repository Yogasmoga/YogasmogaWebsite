<?php
/**
 * @copyright   Copyright (c) 2009-11 Amasty
 */
class Amasty_Rules_Model_SalesRule_Quote_Discount extends Mage_SalesRule_Model_Quote_Discount
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add discount total information to address
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Amasty_Rules_Model_SalesRule_Quote_Discount
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (!Mage::getStoreConfig('amrules/general/breakdown'))
            return parent::fetch($address);
        
        $amount = $address->getDiscountAmount();
        if ($amount != 0) {
            $address->addTotal(array(
                'code'      => $this->getCode(),
                'title'     => Mage::helper('sales')->__('Discount'),
                'value'     => $amount,
                'full_info' => $address->getFullDescr(),
            ));
        }
        return $this;
    }
    
  public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        Mage_Sales_Model_Quote_Address_Total_Abstract::collect($address);
        $quote = $address->getQuote();
        $store = Mage::app()->getStore($quote->getStoreId());
        $this->_calculator->reset($address);

        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this;
        }

        $eventArgs = array(
            'website_id'        => $store->getWebsiteId(),
            'customer_group_id' => $quote->getCustomerGroupId(),
            'coupon_code'       => $quote->getCouponCode(),
        );

        $this->_calculator->init($store->getWebsiteId(), $quote->getCustomerGroupId(), $quote->getCouponCode());
        $this->_calculator->initTotals($items, $address);

        $address->setDiscountDescription(array());

        $newItems = array();
         $parents = array();
        foreach ($items as $newItem){
           $newItems[$newItem->getId()] = $newItem;
           if ($newItem->getParentItemId()) {
               $parents[] = $newItem->getParentItemId();
           }
        }
        
        foreach ($items as $item) {
           if ($item->getParentItemId() && $newItems[$item->getParentItemId()]->getProductType() == 'configurable') {
               $item->setCalculationPrice($newItems[$item->getParentItemId()]->getCalculationPrice());
               $item->setBaseCalculationPrice($newItems[$item->getParentItemId()]->getBaseCalculationPrice());
               $item->setDiscountCalculationPrice($newItems[$item->getParentItemId()]->getDiscountCalculationPrice());
               $item->setBaseDiscountCalculationPrice($newItems[$item->getParentItemId()]->getBaseDiscountCalculationPrice());
           }
            
        }
        
        foreach ($items as $item) {
            if ($item->getNoDiscount()) {
                $item->setDiscountAmount(0);
                $item->setBaseDiscountAmount(0);
            }
            else {
                /**
                 * Child item discount we calculate for parent
                 */
                 if ($item->getProductType() == 'configurable') {
                    continue;   
                 }
                 
                 // skip by setting bundle
                  if (Mage::getStoreConfig('amrules/general/bundle_separate')){
                      if ($item->getProductType() == 'bundle') {
                          continue;   
                      }                        
                  }

                $eventArgs['item'] = $item;
                Mage::dispatchEvent('sales_quote_address_discount_item', $eventArgs);

                if ($item->getHasChildren() && $item->isChildrenCalculated()) { 
                    foreach ($item->getChildren() as $child) { 
                        $this->_calculator->process($child);
                        $eventArgs['item'] = $child;
                        Mage::dispatchEvent('sales_quote_address_discount_item', $eventArgs);
                        $this->_aggregateItemDiscount($child);
                    }
                   $this->_calculator->process($item);
                    $this->_aggregateItemDiscount($item);
                } else {
                    $this->_calculator->process($item);
                    $this->_aggregateItemDiscount($item);
                }
            }
        }

        /**
         * Process shipping amount discount
         */
        $address->setShippingDiscountAmount(0);
        $address->setBaseShippingDiscountAmount(0);
        if ($address->getShippingAmount()) {
            $this->_calculator->processShippingAmount($address);
            $this->_addAmount(-$address->getShippingDiscountAmount());
            $this->_addBaseAmount(-$address->getBaseShippingDiscountAmount());
        }

        $this->_calculator->prepareDescription($address);
        return $this;
    }    
}
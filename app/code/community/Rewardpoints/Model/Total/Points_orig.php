<?php
/**
 * J2T RewardsPoint2
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@j2t-design.com so we can send you a copy immediately.
 *
 * @category   Magento extension
 * @package    RewardsPoint2
 * @copyright  Copyright (c) 2012 J2T DESIGN. (http://www.j2t-design.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
// >>in case of tax calculation issue, uncomment the appropriate line
//class Rewardpoints_Model_Total_Points extends Mage_Sales_Model_Quote_Address_Total_Discount //magento 1.3.x
//class Rewardpoints_Model_Total_Points extends Mage_SalesRule_Model_Quote_Discount //magento 1.4.x and greater
// ... and comment the following line
class Rewardpoints_Model_Total_Points extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    /*public function __construct()
    {
        //parent::__construct();
        $this->setCode('rewardpoints');
    }*/
    
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        
        if (version_compare(Mage::getVersion(), '1.4.0', '>=') && method_exists($this, '_getAddressItems')){
            $items = $this->_getAddressItems($address);
        } else {
            $items = $address->getAllItems();
        }
        
        if (!count($items)) {
            return $this;
        }

        $totalPPrice = 0;
        $totalPBasePrice = 0;
        
        $this->checkAutoUse($address->getQuote());
        $creditPoints = $this->getCreditPoints($address->getQuote());
        
        $subtotalWithDiscount = 0;
        $baseSubtotalWithDiscount = 0;
        
        $totalDiscountAmount = 0;
        $baseTotalDiscountAmount = 0;
        
        if ($userId = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
            $address->getQuote()->setRewardpointsReferrer($userId);
        }
        
        if ($creditPoints > 0 && $this->checkMinUse($address->getQuote())){
            //$pointsAmount = Mage::helper('rewardpoints/data')->convertPointsToMoney($creditPoints, $address->getCustomerId());
            if ($address->getCustomerId()){
                $pointsAmount = Mage::helper('rewardpoints/data')->convertPointsToMoney($creditPoints, $address->getCustomerId());
            } elseif ($address->getQuote()->getCustomerId()) {
                $pointsAmount = Mage::helper('rewardpoints/data')->convertPointsToMoney($creditPoints, $address->getQuote()->getCustomerId());
            } else {
                $pointsAmount = 0;//continue;
            }
            
            foreach ($items as $item) {
                /*if ($item->getProduct()->isVirtual()) {
                    continue;
                }*/
                //echo $item->getProduct()->getData('reward_no_discount');
                //die;
                
                
                if ($product = $item->getProduct()) {
                    if ($product->getData('reward_no_discount')) {
                        continue;
                    }
                }
                if (Mage::getStoreConfig('rewardpoints/default/process_tax', $address->getQuote()->getStoreId()) == 1 && Mage::getStoreConfig('tax/calculation/apply_after_discount', $address->getQuote()->getStoreId()) == 0){
                    $tax = ($item->getTaxBeforeDiscount() ? $item->getTaxBeforeDiscount() : $item->getTaxAmount());
                    $row_base_total = $item->getBaseRowTotal() + $tax;
                } else {
                    $row_base_total = $item->getBaseRowTotal();
                }            
                $baseDiscountAmount = min($row_base_total - $item->getBaseDiscountAmount(), $pointsAmount);
                
                if ($baseDiscountAmount > 0){
                    $points = -$baseDiscountAmount;
                    $totalPBasePrice += $points;
                    $discountAmount = $address->getQuote()->getStore()->convertPrice($points, false);
                    $totalPPrice += $discountAmount;
                    
                    if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                        $item->setDiscountAmount(abs($discountAmount)+$item->getDiscountAmount());
                        $item->setBaseDiscountAmount(abs($baseDiscountAmount)+$item->getBaseDiscountAmount());
                    } else {
                        $item->setDiscountAmount(abs($discountAmount)+$item->getDiscountAmount());
                        $item->setBaseDiscountAmount(abs($baseDiscountAmount)+$item->getBaseDiscountAmount());
                        
                        
                        $item->setRowTotalWithDiscount($item->getRowTotal()-$item->getDiscountAmount());
                        $item->setBaseRowTotalWithDiscount($item->getBaseRowTotal()-$item->getBaseDiscountAmount());

                        $subtotalWithDiscount += $item->getRowTotalWithDiscount();
                        $baseSubtotalWithDiscount += $item->getBaseRowTotalWithDiscount();
                    }
                    
                    //$totalDiscountAmount += $item->getDiscountAmount();
                    //$baseTotalDiscountAmount += $item->getBaseDiscountAmount();
                    
                    $totalDiscountAmount += abs($discountAmount);
                    $baseTotalDiscountAmount += abs($baseDiscountAmount);
                    
                    
                }
                
                $pointsAmount -= $baseDiscountAmount;
            }

            //J2T process shipping address
            $shipping_process = Mage::getStoreConfig('rewardpoints/default/process_shipping', $address->getQuote()->getStoreId());
            if (version_compare(Mage::getVersion(), '1.4.0', '>=') && $shipping_process){
                $shipping_tax = 0;
                if (Mage::getStoreConfig('rewardpoints/default/process_tax', $address->getQuote()->getStoreId()) == 1 && Mage::getStoreConfig('tax/calculation/apply_after_discount', $address->getQuote()->getStoreId()) == 0){
                    $shipping_tax = $address->getBaseShippingTaxAmount();
                }
                
                $baseShippingDiscountAmount = min(($address->getBaseShippingAmount()+$shipping_tax), $pointsAmount);
                $points = -$baseShippingDiscountAmount;
                $totalPBasePrice += $points;
                $totalPPrice += $address->getQuote()->getStore()->convertPrice($points, false);
                $pointsAmount -= $baseShippingDiscountAmount;
            }
            //J2T end process shipping address
            
            
            if ($pts = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote())){
                $address->getQuote()
                        ->setRewardpointsQuantity($pts)
                        ->setBaseRewardpoints(-$totalPBasePrice)
                        ->setRewardpoints(-$totalPPrice);
                        //->save();
            }

            if (abs($totalPBasePrice) > 0){
                $points_used = Mage::helper('rewardpoints/data')->convertMoneyToPoints(abs($totalPBasePrice));
                $points_session = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote());
                if ($points_used < $points_session){
                    Mage::helper('rewardpoints/event')->setCreditPoints($points_used);
                    
                    $address->getQuote()
                            ->setRewardpointsQuantity($points_used)
                            ->setBaseRewardpoints(-$totalPBasePrice)
                            ->setRewardpoints(-$totalPPrice);
                                //->save();
                    
                }
            } else {
                //remove all reward points within this cart
                if ($referrer_id = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
                    Mage::getSingleton('rewardpoints/session')->unsetAll();
                    Mage::getSingleton('rewardpoints/session')->setReferralUser($referrer_id);
                } else {
                    Mage::getSingleton('rewardpoints/session')->unsetAll();
                }
                Mage::helper('rewardpoints/event')->removeCreditPoints($address->getQuote());
            }


            /*$this->_setAmount($totalPPrice)
                ->_setBaseAmount($totalPBasePrice);*/
            
            if ($pts = Mage::helper('rewardpoints/event')->getCreditPoints($address->getQuote())){
                $title = Mage::helper('rewardpoints')->__('%s smogi bucks used', $pts);
                
                $address->getQuote()->setRewardpointsDescription($title);
                //$title_base = $title;
                
                $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', $address->getQuote()->getStoreId());
                $remove_link = Mage::getStoreConfig('rewardpoints/default/remove_link', $address->getQuote()->getStoreId());
                if (!$auto_use && $remove_link && !Mage::getSingleton('admin/session')->isLoggedIn()){
                    //$title .= ' <a href="javascript:$(\'discountFormPoints2\').submit();" title="'.Mage::helper('rewardpoints')->__('Remove Points').'"><img src="'.Mage::getDesign()->getSkinUrl('images/j2t_delete.gif').'" alt="'.Mage::helper('rewardpoints')->__('Remove Points').'" /></a>';
                    //$title .= '<span id="link_j2t_rewards"></span>';
                }
                
                if ($address->getDiscountDescription() != ''){
                    $desc_array = $address->getDiscountDescriptionArray();
                    $desc_array[] = $title;
                    $address->setDiscountDescriptionArray($desc_array);
                    //$address->setDiscountDescriptionArray($couponCode);
                    $address->setDiscountDescription($address->getDiscountDescription().', '.$title);
                } else {
                    $address->setDiscountDescription($title);
                    $address->setDiscountDescriptionArray(array($title));
                }
                
                //if (version_compare(Mage::getVersion(), '1.6.0', '>=')){
                //if (version_compare(Mage::getVersion(), '1.4.0', '>=')){
                if (version_compare(Mage::getVersion(), '1.4.0.1', '>=')){
                    
                    $address->setDiscountAmount($address->getDiscountAmount()+$totalPPrice);                
                    $address->setBaseDiscountAmount($address->getBaseDiscountAmount()+$totalPBasePrice);
                    
                    $this->_addAmount($totalPPrice);
                    $this->_addBaseAmount($totalPBasePrice);
                } else {
                    $address->setDiscountAmount($address->getDiscountAmount()+$totalDiscountAmount);
                    $address->setSubtotalWithDiscount($subtotalWithDiscount);
                    $address->setBaseDiscountAmount($address->getBaseDiscountAmount()+$baseTotalDiscountAmount);
                    $address->setBaseSubtotalWithDiscount($baseSubtotalWithDiscount);
                    if ($coupon = $address->getCouponCode()){
                        $address->setCouponCode($address->getCouponCode().', '.$title);
                    } else {
                        $address->setCouponCode($title);
                    }
                    $address->setGrandTotal($address->getGrandTotal() - $totalDiscountAmount);
                    $address->setBaseGrandTotal($address->getBaseGrandTotal()-$baseTotalDiscountAmount);
                }
                
                //if ($address->getQuote()->getRewardpointsQuantity() != $pts && $pts > 0){
            }
            
        } else {
            //remove all reward points within this cart
            if ($referrer_id = Mage::getSingleton('rewardpoints/session')->getReferralUser()){
                Mage::getSingleton('rewardpoints/session')->unsetAll();
                Mage::getSingleton('rewardpoints/session')->setReferralUser($referrer_id);
            } else {
                Mage::getSingleton('rewardpoints/session')->unsetAll();
            }
            Mage::helper('rewardpoints/event')->removeCreditPoints($address->getQuote());
        }
        
        return $this;
    }

    
    /*public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $pts = $this->getCreditPoints();
        $amount = $address->getRewardpointsAmount();
        
        if ($amount != 0 && $address->getAddressType() == 'shipping') {
            $title = Mage::helper('rewardpoints')->__('%s points used', $pts);
            //skin/frontend/default/default/images/j2t_delete.gif
            $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
            if (!$auto_use){
                $title .= ' <a href="javascript:$(\'discountFormPoints2\').submit();" title="'.Mage::helper('rewardpoints')->__('Remove Points').'"><img src="'.Mage::getDesign()->getSkinUrl('images/j2t_delete.gif').'" alt="'.Mage::helper('rewardpoints')->__('Remove Points').'" /></a>';
            }
            
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $title,
                'value' => $amount
            ));
        }
        return $this;
    }*/

    
    /*public function getLabel()
    {
        return Mage::helper('rewardpoints')->__('Points');
    }*/
    
    protected function getCreditPoints($quote)
    {
        return Mage::helper('rewardpoints/event')->getCreditPoints($quote);
    }
    
    protected function checkMinUse($quote)
    {
        $store_id = $quote->getStoreId();
        if ($quote->getCustomerId()){
            $customerId = $quote->getCustomerId();
        } else {
            $customerId = Mage::getModel('customer/session')->getCustomerId();
        }
        $min_use = Mage::getStoreConfig('rewardpoints/default/min_use', $store_id);
        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_model = Mage::getModel('rewardpoints/flatstats');
            $customer_points = $reward_model->collectPointsCurrent($customerId, $store_id);
        } else {
            $reward_model = Mage::getModel('rewardpoints/stats');
            $customer_points = $reward_model->getPointsCurrent($customerId, $store_id);
        }
        if ($min_use > $customer_points){
            return false;
        }
        return true;
    }
    
    protected function checkAutoUse($quote){
        $customer = Mage::getSingleton('customer/session');
        $store_id = $quote->getStoreId();
        if ($customer->isLoggedIn()){
            
            if ($quote->getCustomerId()){
                $customerId = $quote->getCustomerId();
            } else {
                $customerId = Mage::getModel('customer/session')->getCustomerId();
            }
            
            //$auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', Mage::app()->getStore()->getId());
            $auto_use = Mage::getStoreConfig('rewardpoints/default/auto_use', $store_id);
            if ($auto_use){
                if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
                    $reward_model = Mage::getModel('rewardpoints/flatstats');
                    $customer_points = $reward_model->collectPointsCurrent($customerId, $store_id);
                } else {
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $customer_points = $reward_model->getPointsCurrent($customerId, $store_id);
                }

                if ($customer_points && $customer_points > Mage::helper('rewardpoints/event')->getCreditPoints($quote)){
                    $cart_amount = Mage::getModel('rewardpoints/discount')->getCartAmount();
                    $cart_amount = Mage::helper('rewardpoints/data')->processMathValue($cart_amount);
                    $points_value = min(Mage::helper('rewardpoints/data')->convertMoneyToPoints($cart_amount), (int)$customer_points);

                    //echo $points_value;
                    //die;
                    Mage::getSingleton('customer/session')->setProductChecked(0);
                    Mage::helper('rewardpoints/event')->setCreditPoints($points_value);
                    
                    $quote->setRewardpointsQuantity($points_value);
                    //->save();
                }
            }
        }
    }
}

<?php
class Ankitsinghania_Smogiexpirationnotifier_Model_Applyremovediscount extends Mage_Core_Model_Abstract {
    public function test()
    {
        echo 'test';die;
    }

    public function removesmogibucks()
    {
        try{
            Mage::getSingleton('core/session')->setCPmsg('');
            Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
            Mage::helper('rewardpoints/event')->setCreditPoints(0);
            Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity(NULL)
                ->setRewardpointsDescription(NULL)
                ->setBaseRewardpoints(NULL)
                ->setRewardpoints(NULL)
                ->save();

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    public function automaticapplysmogibucks()
    {
        //activate smogi bucks
        $response = array(
            "status" => "error",
            "error"  => "",
            "success_message" => ""
        );
        try{
            $session = Mage::getSingleton('core/session');
            $points_value = $this->getCustomerPoints();
            $points_max = 0;
            if (Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId())){
                if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId()) < $points_value){
                    $points_max = (int)Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId());
                    $session->addError($this->__('You tried to use %s loyalty points, but you can use a maximum of %s points per shopping cart.', $points_value, $points_max));
                    $points_value = $points_max;
                }
            }
            $quote_id = Mage::helper('checkout/cart')->getCart()->getQuote()->getId();

            Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
            Mage::getSingleton('rewardpoints/session')->setShippingChecked(0);

            Mage::helper('rewardpoints/event')->setCreditPoints($points_value);

            $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals(); //Total object
            $grandtotal = $totals["grand_total"]->getValue();
            if($points_value > $grandtotal)
                $points_value = $grandtotal;
            Mage::log($points_value,null,"autoapply.log");
            Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity($points_value)
                ->save();
            //$response['status'] = "success";

        }catch (Exception $e){
            $response['status'] = "error";
            //echo json_encode($response);
            return false;
        }
        //deactivate gift card

        Mage::getSingleton('giftcards/session')->setActive('0');
        try {
            Mage::getSingleton('checkout/cart')->getQuote()->getShippingAddress()->setCollectShippingRates(true);
            Mage::getSingleton('checkout/cart')->getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            //$response['status'] = "error";
            //echo json_encode($response);
            return false;

        }
       // $response['status'] = "success";
        //echo json_encode($response);

        return true;

    }

    public function getCustomerPoints() {

        if ($this->points_current){
            return $this->points_current;
        }

        $customerId = Mage::getModel('customer/session')->getCustomerId();
        $store_id = Mage::app()->getStore()->getId();

        if (Mage::getStoreConfig('rewardpoints/default/flatstats', $store_id)){
            $reward_flat_model = Mage::getModel('rewardpoints/flatstats');
            $this->points_current = $reward_flat_model->collectPointsCurrent($customerId, $store_id);
            return $this->points_current;
        }

        $reward_model = Mage::getModel('rewardpoints/stats');
        $this->points_current = $reward_model->getPointsCurrent($customerId, $store_id);

        return $this->points_current;
    }

    public function  getCouponCode()
    {
        return Mage::getSingleton('checkout/cart')->getQuote()->getCouponCode();
    }

    // code for remove all promotion code when login

    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }

    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }

    protected function _getQuote()
    {
        return $this->_getCart()->getQuote();
    }

    function getCartItemCount()
    {
        return $this->_getCart()->getQuote()->getItemsCount();

    }


    public function applycouponcode($remove = '', $couponCode = '' )
    {
        /**
         * No reason continue with empty shopping cart
         */
        $response = array(
            "status" => 'error',
            "errors" => '',
            "success_message" => ""
        );
        $errors = array();

        if (!$this->getCartItemCount()) {
//            $response['errors'] = "Your cart is empty";
//            echo json_encode($response);
            return "Your cart is empty";
        }

        //$couponCode = (string) $this->getRequest()->getParam('coupon_code');
        //$remove = (string) $this->getRequest()->getParam('remove');
        $couponCode = (string) $couponCode;
        $remove = (string) $remove;
        if(!strlen($couponCode) && !strlen($remove) )
        {
//            $response['errors'] = "Promo code can't be empty";
//            echo json_encode($response);
            return "Promo code can't be empty";
        }
        if ($remove == 1) {
            $couponCode = '';
        }
        $oldCouponCode = $this->_getQuote()->getCouponCode();

        if (!strlen($couponCode) && !strlen($oldCouponCode)) {
//            $response['errors'] = "No Coupon code applied";
//            echo json_encode($response);
            echo 'no coupon and no oldcoupon';
            return "No Coupon code applied";
        }

        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->setCouponCode(strlen($couponCode) ? $couponCode : '')
                ->collectTotals()
                ->save();

            if (strlen($couponCode)) {
                if ($couponCode == $this->_getQuote()->getCouponCode()) {
                    $this->_getSession()->addSuccess(
                        $this->__('Coupon code "%s" was applied.', Mage::helper('core')->htmlEscape($couponCode))
                    );
//                    $response['success_message'] = "Coupon code".$couponCode."was applied Successfully";
//                    $response['status'] = "success";
//                    echo json_encode($response);
                    return "Coupon code".$couponCode."was applied Successfully";
                }
                else {
                    $this->_getSession()->addError(
                        $this->__('cpnerror-msgCoupon code "%s" is not valid.', Mage::helper('core')->htmlEscape($couponCode))
                    );
//                    $response['errors'] = "Promo code is not valid";
//                    echo json_encode($response);
                    return "Promo code is not valid";
                }
            } else {
                //$this->_getSession()->addSuccess($this->__('Coupon code was canceled.'));
                //echo 'empty set';
//                $response['status'] = "success";
//                $response['success_message'] = "Promo code remove successfully.";
//                echo json_encode($response);
                return "Promo code remove successfully.";
            }

        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError("cpnerror-msg".$e->getMessage());
//            $response['errors'] = "Cannot apply the Promo code.";
//            echo json_encode($response);
            return "Cannot apply the Promo code.";
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__('cpnerror-msgCannot apply the coupon code.'));
            Mage::logException($e);
//            $response['errors'] = "Cannot apply the Promo code.";
//            echo json_encode($response);
            return "Cannot apply the Promo code.";
        }

        //$this->_goBack();
    }



}
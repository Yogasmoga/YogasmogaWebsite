<?php
class Mycustommodules_Mynewtheme_PromotionController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        echo "Output newtheme module";
    }

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


    public function applycouponcodeAction()
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
            $response['errors'] = "Your cart is empty";
            echo json_encode($response);
            return;
        }

        $couponCode = (string) $this->getRequest()->getParam('coupon_code');
        $remove = (string) $this->getRequest()->getParam('remove');
        if(!strlen($couponCode) && !strlen($remove) )
        {
            $response['errors'] = "Please enter Promo Code";
            echo json_encode($response);
            return;
        }
        // retrict user to apply  promotion code with gift of ys
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $response['errors'] = "You cannot apply  Promo Code with Gift Card";
            echo json_encode($response);
            return;
        }
        // retrict user to apply Promotion code with smogi bucks
        if(Mage::helper('rewardpoints/event')->getCreditPoints() > 0)
        {
            $response['error'] = "You cannot apply  Promo Code with Smogi Bucks";
            echo json_encode($response);
            return;
        }



        if ($this->getRequest()->getParam('remove') == 1) {
            $couponCode = '';
        }
        $oldCouponCode = $this->_getQuote()->getCouponCode();

        if (!strlen($couponCode) && !strlen($oldCouponCode)) {
            $response['errors'] = "No Coupon code applied";
            echo json_encode($response);
            return;
        }
        //check do not apply smogi bucks for only accesories in cart
        $miniitems = Mage::getSingleton('core/session')->getCartItems();
        if(isset($miniitems))
        {
            $excludecats = Mage::getModel('core/variable')->loadByCode('nosmogicategories')->getValue('plain');
            $excludecats = explode(",", $excludecats);
            $foundOnlyNoSmogiProduct = 0;
            $flag = 0;
            foreach($miniitems as $mitem)
            {
                $mitemProduct = Mage::getModel('catalog/product')->load($mitem['pid']);
                $cids = $mitemProduct->getCategoryIds();

                $flag = 0;
                foreach($excludecats as $key=>$val)
                {
                    $foundOnlyNoSmogiProduct = $this->_value_in_array($cids,$val);
                    if($foundOnlyNoSmogiProduct == 1)
                        $flag = 1;

                }
                if($flag == 0)break;
//                echo $foundOnlyNoSmogiProduct;
//                if($foundOnlyNoSmogiProduct == 0)die('treast');
//                else die('dddd');
            }
            if($flag == 1)
            {
                $response['errors'] = "Promo Codes cannot be used toward Accessories";
                echo json_encode($response);
                return;
            }
        // end check do not apply smogi bucks for only accesories in cart
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
                    $response['success_message'] = "Coupon code ".$couponCode." is applied Successfully.";
                    $response['status'] = "success";
                    echo json_encode($response);
                    return;
                }
                else {
                    $this->_getSession()->addError(
                        $this->__('cpnerror-msgCoupon code "%s" is not valid.', Mage::helper('core')->htmlEscape($couponCode))
                    );
                    $response['errors'] = "Promo code is not valid.";
                    echo json_encode($response);
                    return;
                }
            } else {
                $this->_getSession()->addSuccess($this->__('Coupon code was canceled.'));
                $response['status'] = "success";
                $response['success_message'] = "Promo code has been removed successfully.";
                echo json_encode($response);
                return;
            }

        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError("cpnerror-msg".$e->getMessage());
            $response['errors'] = "Cannot apply the Promo code.";
            echo json_encode($response);
            return;
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__('cpnerror-msgCannot apply the coupon code.'));
            Mage::logException($e);
            $response['errors'] = "Cannot apply the Promo code.";
            echo json_encode($response);
            return;
        }

        //$this->_goBack();
    }



    
}
    public function _value_in_array($array, $find){
        $exists = 0;
        if(!is_array($array)){
            return;
        }
        foreach ($array as $key => $value) {

            if($find == $value){
                $exists = 1;
            }
        }
        return $exists;
    }
}
?>
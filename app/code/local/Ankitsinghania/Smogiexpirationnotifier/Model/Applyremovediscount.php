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

}
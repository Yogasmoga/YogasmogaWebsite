<?php
class Mycustommodules_Mynewtheme_SmogiController extends Mage_Core_Controller_Front_Action
{
    protected $points_current;
    public function testAction()
    {
        echo "Output newtheme_smogicontroller";
    }
    protected function getQuote()
    {
        return Mage::getSingleton('checkout/cart')->getQuote();
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

    function getPointsInfo() {
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        $reward_model = Mage::getModel('rewardpoints/stats');
        $store_id = Mage::app()->getStore()->getId();

        $customerPoints = $this->getCustomerPoints();
        //$customerPoints = $reward_model->getPointsCurrent($customerId, $store_id);

        //points required to get 1 €
        $points_money = Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId());
        //step to reach to get discount
        $step = Mage::getStoreConfig('rewardpoints/default/step_value', Mage::app()->getStore()->getId());
        //check if step needs to apply
        $step_apply = Mage::getStoreConfig('rewardpoints/default/step_apply', Mage::app()->getStore()->getId());
        $full_use = Mage::getStoreConfig('rewardpoints/default/full_use', Mage::app()->getStore()->getId());

        $order_details = Mage::helper('checkout/cart')->getCart()->getQuote()->getSubtotal();

        $min_use = Mage::getStoreConfig('rewardpoints/default/min_use', Mage::app()->getStore()->getId());


        /*if (Mage::getStoreConfig('rewardpoints/default/process_tax', Mage::app()->getStore()->getId()) == 1){
            $order_details = $this->getQuote()->getSubtotalInclTax();
        }*/
        $order_details = Mage::getModel('rewardpoints/discount')->getCartAmount();


        $cart_amount = Mage::helper('rewardpoints/data')->processMathValue($order_details);
        $max_use = min(Mage::helper('rewardpoints/data')->convertMoneyToPoints($cart_amount), $customerPoints);

        return array('min_use' => $min_use, 'customer_points' => $customerPoints, 'points_money' => $points_money, 'step' => $step, 'step_apply' => $step_apply, 'full_use' => $full_use, 'max_use' => $max_use);
    }

    public function applysmogibucksAction()
    {
        $response = array(
            "status" => "error",
            "error"  => "",
            "success_message" => ""
        );

        // retrict user to apply Smogi Bucks with Promotion Code
        if(Mage::getSingleton('checkout/session')->getQuote()->getCouponCode())
        {
            $response['error'] = "You cannot apply Smogi Bucks with Promotion Code.";
            echo json_encode($response);
            return;
        }
        // retrict user to apply  smogi bucks with gift of ys
        if(Mage::getSingleton('giftcards/session')->getActive() == "1" && Mage::helper('giftcards')->getCustomerBalance(Mage::getSingleton('customer/session')->getCustomer()->getId()))
        {
            $response['errors'] = "You cannot apply Smogi Bucks with Gift Card.";
            echo json_encode($response);
            return;
        }


        $point_details = $this->getPointsInfo();
        //echo '<pre>';print_r($point_details);
        $session = Mage::getSingleton('core/session');
        $points_value = $this->getRequest()->getParam('points_to_be_used');
        // check if required points are greater than customer points
        if($points_value > $point_details['customer_points'])
        {
            $response['error'] = "Insufficient Points. Maximum points is ".$point_details['customer_points'];
            echo json_encode($response);
            return;
        }
        Mage::getSingleton('core/session')->setCPmsg($points_value);

        if (Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId())){
            if ((int)Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId()) < $points_value){
                $points_max = (int)Mage::getStoreConfig('rewardpoints/default/max_point_used_order', Mage::app()->getStore()->getId());
                $session->addError($this->__('You tried to use %s loyalty points, but you can use a maximum of %s points per shopping cart.', $points_value, $points_max));
                $points_value = $points_max;
            }
        }
        $numOfItemInCart = (int)Mage::helper('checkout/cart')->getCart()->getQuote()->getItemsCount();
        if($numOfItemInCart < 1)
        {
            $response['error'] = "Your Cart is Empty";
            echo json_encode($response);
            return;
        }
        $quote_id = Mage::helper('checkout/cart')->getCart()->getQuote()->getId();

        Mage::getSingleton('rewardpoints/session')->setProductChecked(0);
        Mage::getSingleton('rewardpoints/session')->setShippingChecked(0);

        Mage::helper('rewardpoints/event')->setCreditPoints($points_value);


        Mage::helper('checkout/cart')->getCart()->getQuote()
            ->setRewardpointsQuantity($points_value)
            ->save();

        $response['success_message'] = "You are currently using ".$points_value." Bucks of your ".$point_details['customer_points']." Smogi Bucks available. ";
        $response['status'] = "success";
        echo json_encode($response);
        return;

    }

    public function removesmogibucksAction(){
        $response = array(
            "status" => "error",
            "error"  => "",
            "success_message" => ""
        );
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
            $response['status'] = "success";
            $response['success_message'] = "Smogi bucks are successfully removed";
            echo json_encode($response);
            return;
        }
        catch (Exception $e)
        {
                $response['error'] = "There has been an error in removing smogi bucks";
                echo json_encode($response);
                return;
        }
    }

    public function automaticapplysmogibucksAction()
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


            Mage::helper('checkout/cart')->getCart()->getQuote()
                ->setRewardpointsQuantity($points_value)
                ->save();
            $response['status'] = "success";

        }catch (Exception $e){
                $response['status'] = "error";
                echo json_encode($response);
                return;
            }
        //deactivate gift card

        Mage::getSingleton('giftcards/session')->setActive('0');
        try {
            Mage::getSingleton('checkout/cart')->getQuote()->getShippingAddress()->setCollectShippingRates(true);
            Mage::getSingleton('checkout/cart')->getQuote()->collectTotals()->save();
        } catch (Exception $e) {
            $response['status'] = "error";
            echo json_encode($response);
            return;

        }
        $response['status'] = "success";
        echo json_encode($response);
        return;

    }

    public function getPointsCurrentlyUsedAction() {
        $creditpointsentered = Mage::helper('rewardpoints/event')->getCreditPoints();
        $grandTotal = Mage::helper('checkout/cart')->getQuote()->getSubtotal();
        //print_r($grandTotal);
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $cartHelper = Mage::helper('checkout/cart');
        $items = $cartHelper->getCart()->getItems();

        foreach ($items as $item) {
            if($item->getPrice() > 0)
            {
                $itemId = $item->getProductId();
                $itemstotal = $item->getRowTotal();

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
                        //if($categoryid[$id]['category_id'] == 8)
                        //if($categoryid[$id]['name'] == 'Accessories')
                    {
                        $cattotal = $cattotal + $itemstotal;
                    }
                }
            }
        }

        $grandTotal = $grandTotal - $cattotal;

        if ($creditpointsentered > $grandTotal)
        {
            //Mage::getSingleton('core/session')->setCreditPointsApplied($grandTotal);
            echo $grandTotal;
            return $grandTotal;
        }
        else
        {
            echo $creditpointsentered;
            return $creditpointsentered;
        }

    }

}
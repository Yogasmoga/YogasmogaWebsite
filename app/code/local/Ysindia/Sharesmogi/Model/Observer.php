<?php
/**
 * Created by PhpStorm.
 * User: BlankO
 * Date: 23-08-2016
 * Time: 01:34 PM
 *
 * This is a Observer for share smogi module.
 * Created by Fahim Khan (Sr. Magento Developer).
 *
 */
class Ysindia_Sharesmogi_Model_Observer{

    public  function customerOrderSuccessForSmogi(Varien_Event_Observer $observer){

        $orderId =  Mage::getSingleton('checkout/session')->getLastRealOrderId();
        $orderDetails = Mage::getModel('sales/order')->loadByIncrementId($orderId);

        $orderedEmail =  $orderDetails['customer_email'];
        $coupon = $orderDetails['coupon_code'];
        $adminPoints = Mage::getStoreConfig('tab1/general/smogi', Mage::app()->getStore()->getId());

        $smogiModel =  Mage::getModel('sharesmogi/sharesmogi')->getCollection();
        foreach($smogiModel as $smogi){

            if($smogi->getChildEmail() == $orderedEmail){

                try{

                    $model = Mage::getModel('sharesmogi/sharesmogi')->load($smogi->getSharesmogiId());
                    $model->setChildId($orderId);
                    $model->setChildSmogi($coupon);
                    $model->save();

                    // Substract Smogi bucks from Parent.
                    $store_id = Mage::app()->getStore()->getId();
                    $parentId = $smogi->getParentId();
                    $reward_model = Mage::getModel('rewardpoints/stats');
                    $parentPoints = $reward_model->getPointsCurrent($parentId,$store_id);

                    if(!empty($adminPoints)) {

                        if ($parentPoints >= $adminPoints)
                        {

                            $reward_model->setPointsSpent($adminPoints);
                            $reward_model->setCustomerId($parentId);
                            $reward_model->setStoreId($store_id);
                            $reward_model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);

                            $startDate = Mage::getModel('core/date')->gmtDate(null, Mage::getModel('core/date')->timestamp(time()));
                            $endDate = date('Y-m-d', strtotime($startDate . ' + 183 days'));

                            $reward_model->setDateStart($startDate);
                            $reward_model->setDateEnd($endDate);

                            $reward_model->save();

                        }
                        else{
                            Mage::getSingleton('core/session')->addError($this->__('Sorry You dont have sufficient SMOGI BUCKS.'));
                            return;
                        }
                    }
                    else{
                        Mage::getSingleton('core/session')->addError($this->__('Please Contact to YOGASMOGA Help.'));
                        return;
                    }
                }
                catch (Exception $e){
                    Mage::getSingleton('checkout/session')->addError($e->getMessage());
                }

            }
        }
        /*
        $email = $customer->getEmail();
        $customerId = $customer->getId();


        $smogiModal =  Mage::getModel('sharesmogi/sharesmogi');
        //Mage::log("Registration data Email = ".$customerId, null, "register.log");
        $smogiExistEmail = false;

        $points =Mage::getStoreConfig('tab1/general/smogi', Mage::app()->getStore()->getId());;
        $sharesmogiCollection = $smogiModal->getCollection();
        $id = '';
        foreach($sharesmogiCollection as $smogi){
            if($smogi->getChildEmail() == $email){
                $smogiExistEmail = true;
                $id = $smogi->getSharesmogiId();
                break;
            }
        }

        if($smogiExistEmail) {
            $smogiModal->load($id);
            $smogiModal->setChildSmogi($points);
            $smogiModal->setStatus(1);
            $smogiModal->save();
            $store_id = Mage::app()->getStore()->getId();
            $reward_model = Mage::getModel('rewardpoints/stats');
            $reward_model->setPointsCurrent($points);
            $reward_model->setCustomerId($customerId);
            $reward_model->setStoreId($store_id);
            $reward_model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);

            $startDate = Mage::getModel('core/date')->gmtDate(null, Mage::getModel('core/date')->timestamp(time()));
            $endDate = date('Y-m-d', strtotime($startDate . ' + 183 days'));

            $reward_model->setDateStart($startDate);
            $reward_model->setDateEnd($endDate);

            $reward_model->save();



        }*/
    }
}
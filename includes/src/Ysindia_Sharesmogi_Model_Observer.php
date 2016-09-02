<?php
/**
 * Created by PhpStorm.
 * User: BlankO
 * Date: 23-08-2016
 * Time: 01:34 PM
 */
class Ysindia_Sharesmogi_Model_Observer{

    public  function customerRegisterSuccessForSmogi(Varien_Event_Observer $observer){

        $event = $observer->getEvent();
        $customer = $event->getCustomer();
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



        }
    }
}
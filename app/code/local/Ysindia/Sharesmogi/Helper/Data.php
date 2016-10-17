<?php
/*
 * This is a controller for share smogi module.
 * Created by Fahim Khan (Sr. Magento Developer).
 */
class Ysindia_Sharesmogi_Helper_Data extends Mage_Core_Helper_Abstract
{
    /*
        public function getChildCouponCode($orderId){

            $orderDetails = Mage::getModel('sales/order')->loadByIncrementId($orderId);

            $orderedEmail =  $orderDetails['customer_email'];
            $coupon = $orderDetails['coupon_code'];

            $smogiModel =  Mage::getModel('sharesmogi/sharesmogi')->getCollection();
            foreach($smogiModel as $smogi){
                if($smogi->getChildEmail() == $orderedEmail){
                    try{
                        $parentEmail = $smogi->getParentEmail();
                        $model = Mage::getModel('sharesmogi/sharesmogi');
                        $model->setParentEmail($parentEmail);
                        $model->setChildEmail($smogi->getChildEmail());
                        $model->setChildId($orderId);
                        $model->setChildSmogi($coupon);
                        $model->save();
                    }
                    catch (Exception $e){
                        Mage::getSingleton('checkout/session')->addError($e->getMessage());
                    }
                }
            }
        }
    */
}
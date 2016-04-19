<?php
require_once 'app/Mage.php';
Mage::app();umask(0);
$post = array();
Mage::getConfig()->init();
$mod  = Mage::getConfig()->loadModules('Rewardpoints');
$reward_model = Mage::getModel('rewardpoints/stats');
//v.2.0.0
$add_delay = 0;
if ($delay = Mage::getStoreConfig('rewardpoints/default/points_delay', $store_id) && $force_nodelay){
     if (is_numeric($delay)){
         $post['date_start'] = $reward_model->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$delay, date("Y")));
         $add_delay = $delay;
      }
      }

     if ($duration = Mage::getStoreConfig('rewardpoints/default/points_duration', $store_id)){
         if (is_numeric($duration)){
          if (!isset($post['date_start'])){
          $post['date_start'] = $reward_model->getResource()->formatDate(time());
          }
          $post['date_end'] = $reward_model->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d")+$duration+$add_delay, date("Y")));
        }
      }
var_dump($post);



        //check if points are already processed
        $test_points = $reward_model->checkProcessedOrder($customerId = 32090, $orderId = -3, true);
        if (!$test_points->getId()) {
            $post = array('order_id' => $orderId, 'customer_id' => $customerId, 'store_id' => Mage::app()->getStore()->getId(), 'points_current' => $pointsInt, 'convertion_rate' => Mage::getStoreConfig('rewardpoints/default/points_money', Mage::app()->getStore()->getId()));
            //v.2.0.0
            $add_delay = 0;
            if ($delay = Mage::getStoreConfig('rewardpoints/default/points_delay', Mage::app()->getStore()->getId())) {
                if (is_numeric($delay)) {
                    $post['date_start'] = $reward_model->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d") + $delay, date("Y")));
                    $add_delay = $delay;
                }
            }

            if ($duration = Mage::getStoreConfig('rewardpoints/default/points_duration', Mage::app()->getStore()->getId())) {
                if (is_numeric($duration)) {
                    if (!isset($post['date_start'])) {
                        $post['date_start'] = $reward_model->getResource()->formatDate(time());
                    }
                    $post['date_end'] = $reward_model->getResource()->formatDate(mktime(0, 0, 0, date("m"), date("d") + $duration + $add_delay, date("Y")));
                }
            }
            $reward_model->setData($post);
            $reward_model->save();
        } elseif (Mage::getStoreConfig('rewardpoints/default/allow_recalculate', Mage::app()->getStore()->getId())) {
            $reward_model->load($test_points->getId());
            $reward_model->setPointsCurrent($pointsInt);
            $reward_model->save();
        }


var_dump($post);
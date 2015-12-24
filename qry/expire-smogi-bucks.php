<?php

exit;

require '../app/Mage.php';

ini_set('max_execution_time', 600);

Mage::app();

$expire = false;

if(isset($_REQUEST['expire'])){
    if($_REQUEST['expire']=='y')
        $expire = true;
}

$customers = Mage::getModel('customer/customer')->getCollection();

$count = 0;
foreach($customers as $customer) {

    $customerId = $customer->getId();
    $customerEmail = $customer->getEmail();
    $store_id = Mage::app()->getStore()->getId();
    $reward_model = Mage::getModel('rewardpoints/stats');
    $points = $reward_model->getPointsCurrent($customerId, $store_id);

    if($points > 0){

        if($expire) {
            $reward_model->setPointsSpent($points);
            $reward_model->setCustomerId($customerId);
            $reward_model->setStoreId($store_id);
            $reward_model->setOrderId(Rewardpoints_Model_Stats::TYPE_POINTS_ADMIN);

            $startDate = Mage::getModel('core/date')->gmtDate(null, Mage::getModel('core/date')->timestamp(time()));
            $endDate = date('Y-m-d', strtotime($startDate . ' + 183 days'));

            $reward_model->setDateStart($startDate);
            $reward_model->setDateEnd($endDate);

            $reward_model->save();

            ++$count;
        }
        else
            echo "$customerId , $points <br/>";
    }
}

echo "<br/> [$count] customer's reward points set to 0";
?>
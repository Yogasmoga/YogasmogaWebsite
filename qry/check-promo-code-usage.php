<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

$saleRuleModel = Mage::getModel('salesrule/rule');
$rulesCollection = $saleRuleModel->getCollection();

echo "<table style='border:solid 1px #000; width: 400px;'>";
foreach($rulesCollection as $rule) {
    $couponCode = $rule->getName();
    $isActive = $rule->getIsActive();

    $coupon = Mage::getModel('salesrule/coupon');
    $coupon->load($couponCode, 'code');
    if($coupon->getId()) {
        $timesUsed = $coupon->getTimesUsed();
        echo "<tr>";
        echo "<td>$couponCode</td>";
        echo "<td>$timesUsed</td>";
        echo "</tr>";
    }
}
echo "</table>";
<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

$saleRuleModel = Mage::getModel('salesrule/rule');
$rulesCollection = $saleRuleModel->getCollection();
?>

    <table style='border:solid 1px #000; width: 400px;'>
        <tr>
            <td>Coupon Code</td>
            <td>Usage Count</td>
            <td>Order Amount</td>
        </tr>

<?php
foreach($rulesCollection as $rule) {
    $couponCode = $rule->getName();
    $isActive = $rule->getIsActive();

    $coupon = Mage::getModel('salesrule/coupon');
    $coupon->load($couponCode, 'code');

    $orders = Mage::getModel('sales/order')->getCollection()
        ->addFieldToFilter('coupon_code',$couponCode);

    $orderAmount = 0;
    $ar = array();
    foreach($orders as $order) {
        $orderV = Mage::getSingleton('sales/order')->load($order->getId());
        $orderAmount += $orderV->getGrandTotal();
        $ar[] = $order->getIncrementId();
    }

    if($coupon->getId()) {
        $timesUsed = $coupon->getTimesUsed();
        echo "<tr>";
        echo "<td>$couponCode</td>";
        echo "<td>$timesUsed</td>";
        echo "<td>$orderAmount</td>";
        echo "<td>" . implode(',', $ar) . "</td>";
        echo "</tr>";
    }
}
?>
</table>
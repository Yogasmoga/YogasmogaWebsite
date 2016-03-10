<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Check Promo Code Usage</title>
<link href="style.css" type="text/css" rel="stylesheet"/>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
  <body>
		<header><h1>Check Promo Code Usage</h1></header>
		<div class="content">
<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

$saleRuleModel = Mage::getModel('salesrule/rule');
$rulesCollection = $saleRuleModel->getCollection();
?>

    <table class="qry-table-list">
        <thead>
		<tr>
            <td>Coupon Code</td>
            <td>Usage Count</td>
            <td>Total Amount</td>
        </tr>
		</thead>
		<tbody>
<?php
setlocale(LC_MONETARY, 'en_US');
foreach($rulesCollection as $rule) {
    $couponCode = $rule->getName();
    $isActive = $rule->getIsActive();

    $coupon = Mage::getModel('salesrule/coupon');
    $coupon->load($couponCode, 'code');

    $orders = Mage::getModel('sales/order')->getCollection()
        ->addFieldToFilter('coupon_code',$couponCode);

    $orderAmount = 0;
    foreach($orders as $order) {
        $orderV = Mage::getSingleton('sales/order')->load($order->getId());
        $orderAmount += $orderV->getGrandTotal();
    }
	$orderAmount = money_format('$%i', $orderAmount);

    if($coupon->getId()) {
        $timesUsed = $coupon->getTimesUsed();
        echo "<tr>";
        echo "<td>$couponCode</td>";
        echo "<td>$timesUsed</td>";
        echo "<td>$orderAmount</td>";
        echo "</tr>";
    }
}
?>
</tbody>
</table>


</div>

    </body>
</html>
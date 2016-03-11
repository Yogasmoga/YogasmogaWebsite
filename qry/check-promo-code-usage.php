<?php
    function validateDate($date)
    {
        $d = DateTime::createFromFormat('m/d/Y', $date);
        return $d && $d->format('m/d/Y') == $date;
    }

    $datesPassed = false;
    $fromDate = "";
    $toDate = "";

    if(isset($_REQUEST['from']) && isset($_REQUEST['to'])) {
        $fromDateV = $_REQUEST['from'];
        $toDateV = $_REQUEST['to'];

        $datesPassed = validateDate($fromDateV) && validateDate($toDateV);
    }
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Check Promo Code Usage</title>
<link href="style.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#input-from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#input-to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#input-to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#input-from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>
</head>
  <body>
		<header><h1>Check Promo Code Usage</h1>
		<a class="link-home" href="index.php"><i class="fa fa-home"></i></a>
		</header>
		<div class="content">
<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

$saleRuleModel = Mage::getModel('salesrule/rule');
$rulesCollection = $saleRuleModel->getCollection();
?>
	<div class="qry-coupon-by-date">
		<h2 class="h4">Check Promo Code By Date</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<span class="date-from date-spn">
				<label>From: </label><input id="input-from" type="text" name="from" value="<?php echo $fromDateV;?>"/>
			</span>
			<span class="date-to date-spn">
				<label>to: </label><input id="input-to" type="text" name="to" value="<?php echo $toDateV;?>"/>
			</span>
			<span class="date-submit date-spn">
				<input type="submit" value="Submit"/>
			</span>
		</form>
	</div>

    <?php
        if($datesPassed){

            $fromDate = date('Y-m-d', strtotime($fromDateV));
            $toDate = date('Y-m-d', strtotime($toDateV));
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
        ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
        ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE))
        ->addFieldToFilter('coupon_code',$couponCode);

    $orderAmount = 0;
    $timesUsed = 0;
    foreach($orders as $order) {
        $orderV = Mage::getSingleton('sales/order')->load($order->getId());
        $orderAmount += $orderV->getGrandTotal();
        $timesUsed++;
    }
	//$orderAmount = money_format('$%i', $orderAmount);

    if($coupon->getId()) {
        //$timesUsed = $coupon->getTimesUsed();
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

    <?php } ?>

</div>

    </body>
</html>
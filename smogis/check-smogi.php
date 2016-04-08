<?php 
ini_set('max_execution_time',1800);
ini_set('memory_limit', '512M');

if(isset($_REQUEST['from_date'])) {

	require_once '../app/Mage.php';
	Mage::app();
	umask(0);

	$from_date = $_REQUEST['from_date'];
	$to_date = $_REQUEST['to_date'];

	$date_to_from = date("Y-m-d", strtotime($from_date));
	$date_to_now = date("Y-m-d", strtotime($to_date));

	$orders1 = Mage::getModel('sales/order')
		->getCollection()
		->addFieldToFilter('created_at', array('gteq' => $date_to_from,
			'lteq' => $date_to_now
		));
	//->addFieldToFilter('rewardpoints');
	$normalorder = count($orders1->getData());
	echo "Total number of orders:- ".$normalorder."<hr/>";


	$orders = Mage::getModel('sales/order')
		->getCollection()
		->addFieldToFilter('created_at', array('gteq' => $date_to_from,
			'lteq' => $date_to_now
		))
		->addFieldToFilter('rewardpoints',array('neq'=>'null'));
	$rewardpointsOrder = count($orders->getData()) ;
	echo "Orders with Smogi Bucks applied:- ".$rewardpointsOrder."<hr/>";
	$calculation =  ($rewardpointsOrder) *100/$normalorder;
	echo "Percentage of orders with smogi bucks applied:- ".intval($calculation).'%';
	exit;


}
else{?>
	<!DOCTYPE HTML>
	<html>
	<head>
		<meta charset="UTF-8">
		<title>Customer's Orders</title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
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
	<header>
		<h1>Customer's orders and used Smogi Bucks</h1>
	</header>
	<div class="content">

		<form class="qry-form" method="post" action="check-smogi.php">

			<table  border="0">
				<tr>
					<td>From</td>
					<td><input id="input-from" type="text" name="from_date"/> (mm/dd/yyyy)</td>
				</tr>
				<tr>
					<td>To</td>
					<td><input id="input-to" type="text" name="to_date"/> (mm/dd/yyyy)</td>
				</tr>


				<tr>
					<td class="button-area" colspan="2"><input type="submit" value="Get Records"/> </td>
				</tr>
			</table>
		</form>
	</div>

	</body>
	</html>
<?php }?>
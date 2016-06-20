<?php
ini_set("memory_limit", "-1");
set_time_limit(0);


//12-02-2013
require_once '../app/Mage.php';
Mage::app();
umask(0);

if(isset($_REQUEST['from_date'])) {

    

    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];
	$region_id = $_REQUEST['region_id'];
    $sign = $_REQUEST['sign'];
    $amount = $_REQUEST['amount'];

    if($sign=="lteq")
        $signValue = "less than or equal to";
    else if($sign=="gteq")
        $signValue = "greater than or equal to";

    $date_to_from = date("Y-m-d", strtotime($from_date));
    $date_to_now = date("Y-m-d", strtotime($to_date));

	/*$ordercollection = Mage::getModel('sales/order')->getCollection()->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ))
        ->addFieldToFilter('grand_total', array("$sign" => $amount));
	$ordercollection->getSelect()->joinLeft(array('sfoa' => 'sales_flat_order_address'),'main_table.entity_id = sfoa.parent_id',array('region_id'=>'sfoa.region_id'));
	$ordercollection->addFieldToFilter('country_id',array('eq'=>'US'));*/
	
	

   $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ))
        ->addFieldToFilter('grand_total', array("$sign" => $amount));
	
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=customers.csv');

    $fp = fopen('php://output', 'w');

    fputcsv($fp, array("Start Date = " . $from_date));
    fputcsv($fp, array(''));
    fputcsv($fp, array("End Date = " . $to_date));
    fputcsv($fp, array(''));
    fputcsv($fp, array("Amount $signValue =" . $amount));
	fputcsv($fp, array(''));
	fputcsv($fp, array("Region = " . $region_id));

    fputcsv($fp, array(''));
    fputcsv($fp, array(''));
	fputcsv($fp, array("Order ID", "Region", "City", "Email", "Amount", "Sales Tax", "Shipping", "Discount", "Discount Type", "Date"));
    fputcsv($fp, array('','','',''));
	
    foreach ($orders as $order) {
		$orderId = $order->getIncrementId();
        $email = $order->getCustomerEmail();
        $amount = "$".$order->getBaseGrandTotal();
		$shipping = "$".$order->getShippingAmount();
		$tax = "$".$order->getTaxAmount();
        $discount = $order->getBaseDiscountAmount();
        $discountDescription = $order->getDiscountDescription();
        $date = $order->getCreatedAt();
		$countryS = $order->getBillingAddress();
		
		if($countryS){
		$region = $order->getBillingAddress()->getRegion();
		$city = $order->getBillingAddress()->getCity();
		if(trim($order->getBillingAddress()->getRegion()) == trim($region_id)){
			fputcsv($fp, array($orderId, $region, $city, $email, $amount, $tax, $shipping, $discount, $discountDescription, date("d-M-Y", strtotime($date))));
		}
		}
    }
	
    fclose($fp);
    exit;
	
}
else{
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Country Wise Orders</title>
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
		<h1>Country Wise Orders</h1>
		<a class="link-home" href="index.php"><i class="fa fa-home"></i></a>
		</header>
		<div class="content">

        <form class="qry-form" method="post" action="ordersbylocationstate.php">            

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
                    <td>Amount</td>
                    <td><input type="text" name="amount"/></td>
                </tr>
				<!-- <tr>
                    <td>Country</td>
                    <td>
					<select name="country" required>
					
					<?php
						$options = Mage::getResourceModel('directory/country_collection')->load()->toOptionArray();
							foreach($options as $options){
								?>
							<option value="<?php echo $options['value'];?>"><?php echo $options['label'];?></option>
					<?php } ?>
					</select>
					</td>
                </tr> -->
				<tr>
                    <td>State</td>
                    <td>
					<select id="region_id" name="region_id" title="State/Province" class="validate-select">
                            <option value="">Please select region, state or province</option>
							<?php
							$regions = Mage::getModel('directory/country')->load('US')->getRegions();
							foreach($regions as $region)
							{
							?>
								<option value='<?=$region[name]?>'><?=$region['name']?></option>
							<?php
							}
							?>

                        </select>
					</td>
                </tr>
                <tr>
                    <td>Sign</td>
                    <td>
                        <label><input type="radio" name="sign" value="gteq" checked="checked"/> Amount greater than</label>
                        <label><input type="radio" name="sign" value="lteq"/> Amount less than</label>
                    </td>
                </tr>
                <tr>
                    <td class="button-area" colspan="2"><input type="submit" value="Get Records"/> </td>
                </tr>
            </table>
        </form>
   </div>

    </body>
</html>

<?php } ?>
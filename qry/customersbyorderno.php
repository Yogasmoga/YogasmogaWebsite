<?php
ini_set("memory_limit", "-1");
set_time_limit(0);

if(isset($_REQUEST['from_date'])) {

    require_once '../app/Mage.php';
    Mage::app();
    umask(0);

    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];
    $sign = $_REQUEST['sign'];
    $amount = $_REQUEST['amount'];
    $orders_count = $_REQUEST['orders_count'];

    if($sign=="lteq")
        $signValue = "less than or equal to";
    else if($sign=="gteq")
        $signValue = "greater than or equal to";

    $date_to_from = date("Y-m-d", strtotime($from_date));
    $date_to_now = date("Y-m-d", strtotime($to_date));

    $Collection = Mage::getModel('sales/order')->getCollection();
    $Collection->getSelect()->columns('COUNT(*) AS TotalOrder')->group('customer_id')->having('TotalOrder > ?', $orders_count);
    $Collection->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ));
    $orders = $Collection->addFieldToFilter('grand_total', array("$sign" => $amount));
    

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=customers.csv');

    $fp = fopen('php://output', 'w');

    fputcsv($fp, array("Start Date = " . $from_date));
    fputcsv($fp, array(''));
    fputcsv($fp, array("End Date = " . $to_date));
    fputcsv($fp, array(''));
    fputcsv($fp, array("Min Orders Count => " . $orders_count));
    fputcsv($fp, array(''));
    fputcsv($fp, array("Amount $signValue " . $amount));

    fputcsv($fp, array(''));
    fputcsv($fp, array(''));
    fputcsv($fp, array("Email", "Orders Count"));
    fputcsv($fp, array('','','',''));

    foreach ($orders as $order) {
        //echo "<pre>";
        $email = $order->getCustomerEmail();
        $count = $order->getData('TotalOrder');
        fputcsv($fp, array($email,$count));
        //echo "</pre>";
    }

    fclose($fp);

    //readfile('customers.txt');
    exit;
}
else{
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Download customers</title>
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
		<h1>Download customers by orders count</h1>
		<a class="link-home" href="index.php"><i class="fa fa-home"></i></a>
		</header>
		<div class="content">

        <form class="qry-form" method="post" action="">            

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
                    <td>Min. Orders</td>
                    <td><input type="text" name="orders_count" required /></td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td><input type="text" name="amount"/></td>
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
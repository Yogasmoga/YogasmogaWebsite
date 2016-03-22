<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

if (isset($_REQUEST['date'])) {

    $date = date('Y-m-d', strtotime($_REQUEST['date']));
    $registered_date = date('Y-m-d', strtotime($_REQUEST['date']));

    $sql = "SELECT e.email AS email, MAX(o.created_at) AS last_order_date FROM customer_entity AS e LEFT JOIN sales_flat_order AS o ON o.customer_id = e.entity_id WHERE (e.entity_type_id = '1' and e.created_at >='$registered_date') GROUP BY e.entity_id HAVING (last_order_date < '$date') OR (last_order_date IS NULL)";

    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $rows = $readConnection->fetchAll($sql);

    if ($rows && count($rows) >0) {

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=customers.csv');

        $fp = fopen('php://output', 'w');

        fputcsv($fp, array('Customer emails who did not order since: ' . $date));

        fputcsv($fp, array(''));

        foreach($rows as $row) {

            $email = $row['email'];
            $lastOrder = $row['last_order_date'];

            fputcsv($fp, array('email' => $email, 'last order' => $lastOrder));
        }

        fclose($fp);
        exit;
    }

} else {
    ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Download customer who haven't ordered</title>
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
		<h1>Download customers who did not order since a date</h1>
		<a class="link-home" href="index.php"><i class="fa fa-home"></i></a>
		</header>
		<div class="content">

    <form class="qry-form" method="post" action="customersbyinactivity.php">

        

        <table border="0">
            <tr>
                <td>Since</td>
                <td><input id="input-from" type="text" name="date"/></td>
            </tr>
            <tr>
                <td>Registered after</td>
                <td><input id="input-to" type="text" name="register_date"/></td>
            </tr>

            <tr>
                <td class="button-area" colspan="2"><input type="submit" value="Get Records"/></td>
            </tr>
        </table>
        <input type="hidden" name="product_name"/>
    </form>
   </div>

    </body>
</html>
<?php } ?>
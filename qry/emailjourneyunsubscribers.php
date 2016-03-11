<?php

if(isset($_REQUEST['date'])) {

    require_once '../app/Mage.php';
    Mage::app();
    umask(0);

    $date = $_REQUEST['date'];

    $date = date("Y-m-d", strtotime($date));

    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $query = "select * from unsubscribed_customers where date(created_at)='$date'";

    $rows = $readConnection->fetchAll($query);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=unsubscribed.csv');

    $fp = fopen('php://output', 'w');

    fputcsv($fp, array("Customers unsubscribed on " . $date));
    fputcsv($fp, array(''));

    fputcsv($fp, array(''));
    fputcsv($fp, array('S.No.', 'Customer Id', 'Email'));
    fputcsv($fp, array(''));

    $i = 0;
    foreach ($rows as $row) {
        $email = $row['email'];
        $customerId = $row['customer_id'];
        fputcsv($fp, array(++$i, $customerId, $email));
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
<title>Download customers</title>
<link href="style.css" type="text/css" rel="stylesheet"/>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
    $(function() {
    $( "#qry-datepicker" ).datepicker();
  });
  </script>
</head>
  <body>
		<header>
		<h1>Download customers</h1>
		<a class="link-home" href="index.php"><i class="fa fa-home"></i></a>
		</header>
		<div class="content">

        <form class="qry-form" method="post" action="emailjourneyunsubscribers.php">

            

            <table border="0">
                <tr>
                    <td>Date</td>
                    <td><input id="qry-datepicker" type="text" name="date"/> (mm/dd/yyyy)</td>
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
<?php
require_once '../app/Mage.php';
Mage::app();
umask(0);

if (isset($_REQUEST['from_date'])) {

    $productName = $_REQUEST['product_name'];
    $product_id = $_REQUEST['product'];

    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];

    $date_to_from = date("Y-m-d", strtotime($from_date));
    $date_to_now = date("Y-m-d", strtotime($to_date));

    $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ));


    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=customers.csv');

    $fp = fopen('php://output', 'w');

    fputcsv($fp, array('Customer emails who purchased: ' . $productName));

    fputcsv($fp, array('Date range: ' . $from_date . ' to ' . $to_date));

    fputcsv($fp, array(''));

    $emails = array();
    foreach ($orders as $order) {

        $orderId = $order->getIncrementId();
        $orderProduct = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        $items = $orderProduct->getAllVisibleItems();
        foreach ($items as $item) {
            if ($item->getProductId() == $product_id) {

                $email = $order->getCustomerEmail();

                if(isset($emails[$email]))
                    ;
                else {

                    $emails[$email] = $email;

                    fputcsv($fp, array('email' => $email));
                }
            }
        }
    }

    fclose($fp);

    exit;
} else {
    ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Download customer that purchased products</title>
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
		<h1>Download customers who purchased product within specified date</h1>
		<a class="link-home" href="index.php"><i class="fa fa-home"></i></a>
		</header>
		<div class="content">

    <form class="qry-form" method="post" action="customersbyproducts.php">

        

        <table  border="0">
            <tr>
                <?php
                $products = Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*')
                    ->addAttributeToFilter('type_id', array('eq' => 'configurable'))
                    ->addAttributeToSort('name', 'ASC');
                ?>
                <td>Select Product</td>
                <td>
                    <select name="product">
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product->getId(); ?>"><?php echo trim($product->getName()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>From</td>
                <td><input id="input-from" type="text" name="from_date"/></td>
            </tr>
            <tr>
                <td>To</td>
                <td><input id="input-to" type="text" name="to_date"/></td>
            </tr>

            <tr>
                <td class="button-area" colspan="2"><input type="submit" value="Get Records"/></td>
            </tr>
        </table>
        <input type="hidden" name="product_name"/>
    </form>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            var text = jQuery("select[name='product']").children(':selected').text();
            jQuery("input[name='product_name']").val(text);

            jQuery("select[name='product']").change(function(){
                text = jQuery(this).children(':selected').text();

                jQuery("input[name='product_name']").val(text);
            });
        });
    </script>

    </div>

    </body>
</html>

<?php } ?>
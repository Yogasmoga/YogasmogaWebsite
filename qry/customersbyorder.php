<?php

if(isset($_REQUEST['from_date'])) {

    require_once '../app/Mage.php';
    Mage::app();
    umask(0);

    $from_date = $_REQUEST['from_date'];
    $to_date = $_REQUEST['to_date'];
    $sign = $_REQUEST['sign'];
    $amount = $_REQUEST['amount'];

    if($sign=="lteq")
        $signValue = "less than or equal to";
    else if($sign=="gteq")
        $signValue = "greater than or equal to";

    $date_to_from = date("Y-m-d", strtotime($from_date));
    $date_to_now = date("Y-m-d", strtotime($to_date));

    $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToFilter('created_at', array('gteq' => $date_to_from,
            'lteq' => $date_to_now
        ))
        ->addFieldToFilter('grand_total', array("$sign" => $amount));

    $fp = fopen('customers.txt', 'w');

    fwrite($fp, "Start Date = " . $from_date);
    fwrite($fp, PHP_EOL);
    fwrite($fp, PHP_EOL);
    fwrite($fp, "End Date = " . $from_date);
    fwrite($fp, PHP_EOL);
    fwrite($fp, PHP_EOL);
    fwrite($fp, "Amount $signValue " . $amount);
    fwrite($fp, PHP_EOL);
    fwrite($fp, PHP_EOL);

    foreach ($orders as $order) {
        $email = $order->getCustomerEmail();
        fwrite($fp, $email . "\n");
        fwrite($fp, PHP_EOL);
    }

    fclose($fp);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=customers.txt');
    readfile('customers.txt');
    exit;
}
else{
?>

<html>
    <body>
        <form method="post" action="customersbyorder.php">

            <h3>Download customers</h3>

            <table style="width:500px;" border="0">
                <tr>
                    <td style="width:150px;">From</td>
                    <td><input type="text" name="from_date"/> (mm/dd/yyyy)</td>
                </tr>
                <tr>
                    <td style="width:150px;">To</td>
                    <td><input type="text" name="to_date"/> (mm/dd/yyyy)</td>
                </tr>
                <tr>
                    <td style="width:150px;">Amount</td>
                    <td><input type="text" name="amount"/></td>
                </tr>
                <tr>
                    <td style="width:150px;">Sign</td>
                    <td>
                        <label><input type="radio" name="sign" value="gteq" checked="checked"/> Amount greater than</label>
                        <label><input type="radio" name="sign" value="lteq"/> Amount less than</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Get Records"/> </td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php } ?>
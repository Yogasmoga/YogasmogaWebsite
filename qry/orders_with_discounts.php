<?php

if(isset($_REQUEST['from_date'])) {

    require_once '../app/Mage.php';
    Mage::app();
    umask(0);

    $from_date = date("Y-m-d", strtotime($_REQUEST['from_date']));
    $to_date = date("Y-m-d", strtotime($_REQUEST['to_date']));

    $orders = Mage::getModel('sales/order')->getCollection()
        ->addAttributeToFilter('created_at', array('from'=>$from_date, 'to'=>$to_date))
        ->addAttributeToFilter('status', array('eq' => Mage_Sales_Model_Order::STATE_COMPLETE));

    $orders->addFieldToFilter('base_discount_amount', array('lt' => 0));
/*
    foreach($orders as $order){
    echo "<pre>";
    print_r($order);
    echo "</pre>";
    break;
}
    die;
*/

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=orders_with_discounts.csv');

    $fp = fopen('php://output', 'w');

    fputcsv($fp, array($from_date, $to_date, '',''));
    fputcsv($fp, array("Order ID", "Email", "Amount", "Discount", "Discount Type", "Date", "Items"));
    fputcsv($fp, array('','','',''));

    foreach ($orders as $order) {

        $orderId = $order->getIncrementId();
        $email = $order->getCustomerEmail();
        $amount = "$".$order->getBaseGrandTotal();
        $discount = $order->getBaseDiscountAmount();
        $discountDescription = $order->getDiscountDescription();
        $date = $order->getCreatedAt();

        fputcsv($fp, array($orderId, $email, $amount, $discount, $discountDescription, $date));

        $items = $order->getAllVisibleItems();
        foreach($items as $item) {
            $sku = $item->getSku();
            $price = "$".$item->getPrice();
            fputcsv($fp, array('', '', '', '', '', '', $sku, $price));
        }

        fputcsv($fp, array('', '', '', '', '', '', ''));
    }

    fclose($fp);

    exit;
}
else{
    ?>

    <html>
    <body>

    <br/><a href="index.php">Home</a><br/><br/>

    <form method="post" action="orders_with_discounts.php">

        <h3>Download orders with discounts</h3>

        <table style="width:500px;" border="0">
            <tr>
                <td style="width:150px;">From</td>
                <td><input type="date" name="from_date"/> (mm/dd/yyyy)</td>
            </tr>
            <tr>
                <td style="width:150px;">To</td>
                <td><input type="date" name="to_date"/> (mm/dd/yyyy)</td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Get Records"/> </td>
            </tr>
        </table>
    </form>
    </body>
    </html>

<?php } ?>

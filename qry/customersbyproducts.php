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

    fputcsv($fp, array('Customer emails who purchased ' . $productName));

    fputcsv($fp, array('Date range: ' . $from_date . ' - ' . $to_date));

    $emails = array();
    foreach ($orders as $order) {

        $orderId = $order->getIncrementId();
        $orderProduct = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        $items = $orderProduct->getAllVisibleItems();
        foreach ($items as $item) {
            if ($item->getProductId() == $product_id) {
                $email = $order->getCustomerEmail();
                fputcsv($fp, array('email' => $email));
            }
        }
    }

    fclose($fp);

    exit;
} else {
    ?>

    <html>
    <body>
    <form method="post" action="customersbyproducts.php">

        <h3>Download customers</h3>

        <table style="width:500px;" border="0">
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
                            <option value="<?php echo $product->getId(); ?>"><?php echo $product->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:150px;">From</td>
                <td><input type="date" name="from_date"/></td>
            </tr>
            <tr>
                <td style="width:150px;">To</td>
                <td><input type="date" name="to_date"/></td>
            </tr>

            <tr>
                <td colspan="2"><input type="submit" value="Get Records"/></td>
            </tr>
        </table>
        <input type="hidden" name="product_name"/>
    </form>
    </body>
    </html>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("select[name='product']").change(function(){
                var text = jQuery(this).text();

                jQuery("input[name='product_name']").val(text);
            });
        });
    </script>

<?php } ?>
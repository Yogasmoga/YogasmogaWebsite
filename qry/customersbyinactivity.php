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

    <html>
    <head>
        <script type="text/javascript" src="../js/new_jquery/jquery-1.8.2.min.js"></script>
        <title>Download customer who haven't ordered</title>
    </head>
    <body>

    <br/><a href="index.php">Home</a><br/><br/>

    <form method="post" action="customersbyinactivity.php">

        <h3>Download customers who did not order since a date</h3>

        <table style="width:500px;" border="0">
            <tr>
                <td style="width:150px;">Since</td>
                <td><input type="date" name="date"/></td>
            </tr>
            <tr>
                <td style="width:150px;">Registered after</td>
                <td><input type="date" name="register_date"/></td>
            </tr>

            <tr>
                <td colspan="2"><input type="submit" value="Get Records"/></td>
            </tr>
        </table>
        <input type="hidden" name="product_name"/>
    </form>
    </body>
    </html>

<?php } ?>
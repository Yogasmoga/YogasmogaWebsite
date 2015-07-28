<?php

if(isset($_REQUEST['from_date'])) {

    require_once '../app/Mage.php';
    Mage::app();
    umask(0);

    $date = $_REQUEST['date'];

    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $query = 'select * from unsubscribed_customers';

    $rows = $readConnection->fetchAll($query);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=unsubscribed.csv');

    $fp = fopen('php://output', 'w');

    fputcsv($fp, array("Customers unsubscribed on " . $date));
    fputcsv($fp, array(''));

    fputcsv($fp, array(''));
    fputcsv($fp, array('S.No.', 'Customer Id', 'Email', 'Joined On'));
    fputcsv($fp, array(''));

    $i = 0;
    foreach ($rows as $row) {
        $email = $row['email'];
        $customerId = $row['customer_id'];
        fputcsv($fp, array(++$i, $customerId, $email, $date));
    }

    fclose($fp);

    exit;
}
else{
?>

<html>
    <body>

        <br/><a href="index.php">Home</a><br/><br/>

        <form method="post" action="emailjourneyunsubscribers.php">

            <h3>Download customers</h3>

            <table style="width:500px;" border="0">
                <tr>
                    <td style="width:150px;">Date</td>
                    <td><input type="text" name="from_date"/> (mm/dd/yyyy)</td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Get Records"/> </td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php } ?>
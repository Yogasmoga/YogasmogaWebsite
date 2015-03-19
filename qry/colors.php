<?php
    require '../app/Mage.php';

    $app = Mage::app('');

    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read');

    $query = 'select * from eav_attribute_option_value';

    $rows = $readConnection->fetchAll($query);

    if ($rows) {
?>

        <table style="width:800px; text-align: left">
            <thead>
                <tr>
                    <th>Value Id</th>
                    <th>Option Id</th>
                    <th>Store Id</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>

<?php
        foreach($rows as $row){

            $value_id = $row["value_id"];
            $option_id = $row["option_id"];
            $store_id = $row["store_id"];
            $value = $row["value"];
?>

            <tr>
                <td><?php echo $value_id;?></td>
                <td><?php echo $option_id;?></td>
                <td><?php echo $store_id;?></td>
                <td><?php echo $value;?></td>
            </tr>

<?php
        }

        echo "</tbody></table>";
    }
    else
        echo "Nothing found";
?>

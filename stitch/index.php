<?php
include 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

$inputFileName = 'stitch.xlsx';

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
        . '": ' . $e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

$all_products = array();

//  Loop through each row of the worksheet in turn
// row 1 is for headers
for ($row = 2; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
        NULL, TRUE, FALSE);

//    $sku = $rowData[0][1];
//    $name = $rowData[0][2];
//    $unit_price = $rowData[0][4];
//    $total_stock = $rowData[0][9];
//    $brentwood_stock = $rowData[0][15];
//    $fallriver_stock = $rowData[0][12];
//    $magento_stock = $rowData[0][18];
//    $greenwich_stock = $rowData[0][21];
//    $magento_price = $rowData[0][30];

    $sku = $rowData[0][0];
    $name = $rowData[0][1];
    $unit_price = $rowData[0][2];
    $total_stock = $rowData[0][3];
    $brentwood_stock = $rowData[0][4];
    $fallriver_stock = $rowData[0][5];
    $magento_stock = $rowData[0][6];
    $greenwich_stock = $rowData[0][7];
    $magento_price = $rowData[0][8];

    if(strpos($name, '(')===false)
        continue;

    $parenthesis_start_position = strpos($name, '(');
    $parenthesis_end_position = strpos($name, ')');

    $actual_name = trim(substr($name, 0, $parenthesis_start_position));
    $within_parenthesis = trim(substr($name, $parenthesis_start_position + 1, $parenthesis_end_position - $parenthesis_start_position - 1));

    if(strpos($within_parenthesis, ",")===false) {
        $color = $within_parenthesis;
        $size = '';
        $height = '';
    }
    else{
        $ar_within_parenthesis = explode(",", $within_parenthesis);
        $color = $ar_within_parenthesis[0];
        $size = $ar_within_parenthesis[1];

        if(count($ar_within_parenthesis)==3)
            $height = $ar_within_parenthesis[2];
    }

    $all_products[$actual_name][] = array(
        'name' => $actual_name,
        'color' => $color,
        'size' => $size,
        'height' => $height,
        'sku' => $sku,
        'unit_price' => $unit_price,
        'total_stock' => $total_stock,
        'brentwood_stock' => $brentwood_stock,
        'fallriver_stock' => $fallriver_stock,
        'magento_stock' => $magento_stock,
        'greenwich_stock' => $greenwich_stock,
        'magento_price' => $magento_price
    );
}

ksort($all_products);
?>

<table style="width:100%; margin:auto; padding: 20px; border-collapse: collapse;">
    <thead>

    </thead>
    <tbody>
    <?php
    foreach($all_products as $product_name => $data){

        echo "<tr><td colspan='10' style='border-bottom:solid 1px #ccc; padding-bottom:5px;'><b>$product_name</b></td></tr>";
        echo "<tr>";

        $ar_color_size = array();

        foreach($data as $ar){

            if(strlen(trim($ar['height']))>0){
                $ar_color_size[$ar['color'] . '-' . $ar['height']][] = array(
                    'color' => $ar['color'] . '-' . $ar['height'],
                    'size' => $ar['size'],
                    'stock' => $ar['total_stock'],
                    'unit_price' => $ar['unit_price']
                );
            }
            else {
                $ar_color_size[$ar['color']][] = array(
                    'color' => $ar['color'],
                    'size' => $ar['size'],
                    'stock' => $ar['total_stock'],
                    'unit_price' => $ar['unit_price']
                );
            }
        }

        /***************** printing size header *********************/
        $ar_sizes = array();
        // finding sizes
        foreach($ar_color_size as $color_name_value => $color_data ){
            foreach($color_data as $color_size) {

                if(strlen(trim($color_size['size']))>0)
                    $ar_sizes[] = $color_size['size'];
            }
        }

        $ar_sizes = array_unique($ar_sizes);
        asort($ar_sizes);

        echo "<tr style='background: #2c62a5; color: #fff'>";

        echo "<td style='padding:5px;'>Color</td>";
        foreach($ar_sizes as $size){
            echo "<td style='padding:5px; text-align: center'>Size " . $size . "</td>";
        }
        echo "<td style='padding:5px; text-align: center'>Total</td>";
        echo "<td style='padding:5px; text-align: center'>Unit Price</td>";
        echo "<td style='padding:5px; text-align: center'>Net Total</td>";
        echo "</tr>";
        /***************** printing size header *********************/

        $total_products = 0;
        $total_inventories = 0;
        foreach($ar_color_size as $color_name_value => $color_data ){

            echo "<tr>";
            echo "<td style='margin-top: 10px;'>" . $color_name_value . "</td>";

            $ar_size_stock = array();

            $total = 0;
            foreach($color_data as $color_size) {
                if(isset($color_size['size']) && strlen(trim($color_size['size']))>0) {
                    $ar_size_stock[$color_size['size']] = $color_size['stock'];
                    $total += $color_size['stock'];
                }
            }

            $total_products += $total;

            ksort($ar_size_stock);

            $x = 0;
            if(count($ar_size_stock)>0) {
                foreach ($ar_size_stock as $size => $stock) {
                    if(intval($stock)==0)
                        echo "<td style='text-align: center; background-color: #ccc'>$stock</td>";
                    else
                        echo "<td style='text-align: center'>$stock</td>";
                    ++$x;
                }
            }

            // fill td's if there are not enough size available for this product
            if($x>0)
                for($i=$x;$i<count($ar_sizes);$i++)
                    echo "<td style='text-align: center'>&nbsp;</td>";

            if(isset($color_data[0]['unit_price'])) {
                echo "<td style='text-align: center'>$total</td>";
                $unit_price = $color_data[0]['unit_price'];
                echo "<td style='text-align: center'>$unit_price</td>";
                echo "<td style='text-align: center'>" . $total * $unit_price . "</td>";

                $total_inventories += $total * $unit_price;
            }

            echo "</tr>";
        }

        echo "<tr><td style='padding-top:20px; font-weight:bold; color:#2f70cc'>Total inventory of all colors and sizes</td>";
        echo "<td colspan='2' style='padding-top:20px; font-weight:bold; color:2f70cc'>$total_products</td>";
        echo "</tr>";
        echo "<tr><td style='padding-top:10px; font-weight:bold; color:#cc1c3a'>Total price of all inventories</td>";
        echo "<td colspan='2' style='padding-top:20px; font-weight:bold; color:#cc1c3a'>$total_inventories</td>";
        echo "</tr>";

        unset($ar_sizes);

        echo "</tr>";
        echo "<tr><td colspan='10' style='line-height: 30px;'>&nbsp;</td></tr>";
    }
    ?>
    </tbody>
</table>
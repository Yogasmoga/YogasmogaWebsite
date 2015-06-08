<?php
    $inputFileName = 'stitch.xls';

    $upload_display = "display:none";
    $filter_display = "display:none";

    if(file_exists($inputFileName))
        $filter_display = "display:block";
    else
        $upload_display = "display:block";

    $stores = array('all', 'brentwood', 'fallriver', 'magento', 'greenwich');

    $store = 'all';
    if(isset($_GET['store'])) {
        $store = strtolower($_GET['store']);

        if (!in_array($store, $stores))
            $store = 'total';
    }
?>

<html>
<head>
    <script type="text/javascript" src="../js/new_jquery/jquery-1.8.2.min.js"></script>
    <title>Stitch All Inventory Report</title>
</head>
<body style="font-size: 13px; font-family: arial, helvetica, sans-serif">

<?php

if(file_exists($inputFileName)){

include 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

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

$product_names = array();
$all_products = array();

//  Loop through each row of the worksheet in turn
// row 1 is for headers
for ($row = 2; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
        NULL, TRUE, FALSE);

    $sku = $rowData[0][1];
    $name = $rowData[0][2];
    $unit_price = $rowData[0][4];
    $all_stock = $rowData[0][9];
    $brentwood_stock = $rowData[0][15];
    $fallriver_stock = $rowData[0][12];
    $magento_stock = $rowData[0][18];
    $greenwich_stock = $rowData[0][21];
    $magento_price = $rowData[0][30];

//    $sku = $rowData[0][0];
//    $name = $rowData[0][1];
//    $unit_price = $rowData[0][2];
//    $total_stock = $rowData[0][3];
//    $brentwood_stock = $rowData[0][4];
//    $fallriver_stock = $rowData[0][5];
//    $magento_stock = $rowData[0][6];
//    $greenwich_stock = $rowData[0][7];
//    $magento_price = $rowData[0][8];

    if(strpos($name, '(')===false)
        continue;

    $parenthesis_start_position = strpos($name, '(');
    $parenthesis_end_position = strpos($name, ')');

    $actual_name = trim(substr($name, 0, $parenthesis_start_position));
    $within_parenthesis = trim(substr($name, $parenthesis_start_position + 1, $parenthesis_end_position - $parenthesis_start_position - 1));

    if(strpos($within_parenthesis, ",")===false) {
        $color = $within_parenthesis;
        $size = '-';
        $height = '';
    }
    else{
        $ar_within_parenthesis = explode(",", $within_parenthesis);
        $color = $ar_within_parenthesis[0];
        $size = $ar_within_parenthesis[1];

        if(count($ar_within_parenthesis)==3)
            $height = $ar_within_parenthesis[2];
    }

    $product_names[] = $actual_name;

    $all_products[$actual_name][] = array(
        'name' => $actual_name,
        'color' => $color,
        'size' => $size,
        'height' => $height,
        'sku' => $sku,
        'unit_price' => round($unit_price,2),
        'all_stock' => $all_stock,
        'brentwood_stock' => $brentwood_stock,
        'fallriver_stock' => $fallriver_stock,
        'magento_stock' => $magento_stock,
        'greenwich_stock' => $greenwich_stock,
        'magento_price' => $magento_price
    );
}

    $product_names = array_unique($product_names);

ksort($all_products);
?>
<div id="divdata" style="padding-top: 155px;">
<table style="width:100%; margin:auto; padding: 20px; border-collapse: collapse;font-size: 13px; font-family: arial, helvetica, sans-serif">
    <thead>

    </thead>
    <tbody>
    <?php

    $total_all_inventories = 0;
    $total_all_price = 0;

    foreach($all_products as $product_name => $data){

        echo "<tr><td colspan='10' style='border-bottom:solid 1px #ccc; padding-bottom:5px;'><b>$product_name</b></td></tr>";
        echo "<tr>";

        $ar_color_size = array();

        foreach($data as $ar){

            if(strlen(trim($ar['height']))>0){
                $ar_color_size[$ar['color'] . '-' . $ar['height']][] = array(
                    'color' => $ar['color'] . '-' . $ar['height'],
                    'size' => $ar['size'],
                    'stock' => $ar[$store . '_stock'],
                    'unit_price' => $ar['unit_price']
                );
            }
            else {
                $ar_color_size[$ar['color']][] = array(
                    'color' => $ar['color'],
                    'size' => $ar['size'],
                    'stock' => $ar[$store . '_stock'],
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
            echo "<td style='padding:5px; text-align: left; min-width: 65px;'>Size " . $size . "</td>";
        }
        echo "<td style='padding:5px; text-align: left'>Total</td>";
        echo "<td style='padding:5px; text-align: left'>Cost Price</td>";
        echo "<td style='padding:5px; text-align: left'>Total Cost Price</td>";
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
                        echo "<td style='text-align: left; background-color: #ccc'>$stock</td>";
                    else
                        echo "<td style='text-align: left'>$stock</td>";
                    ++$x;
                }
            }

            // fill td's if there are not enough size available for this product
            if($x>0)
                for($i=$x;$i<count($ar_sizes);$i++)
                    echo "<td style='text-align: left'>&nbsp;</td>";

            if(isset($color_data[0]['unit_price'])) {
                echo "<td style='text-align: left'>$total</td>";
                $unit_price = $color_data[0]['unit_price'];
                echo "<td style='text-align: left'>$ " . round($unit_price,2) . "</td>";
                $net_total = $total * $unit_price;
                echo "<td style='text-align: left'>$ " . number_format($net_total, 2, '.', ''). "</td>";

                $total_inventories += $total * $unit_price;
            }

            echo "</tr>";
        }

        echo "<tr><td style='padding-top:20px; font-weight:bold; color:#2f70cc'>Total units: \"Style name\" </td>";
        echo "<td colspan='2' style='padding-top:20px; font-weight:bold; color:2f70cc'>$ " . round($total_products,2) . "</td>";
        echo "</tr>";
        echo "<tr><td style='padding-top:10px; font-weight:bold; color:#cc1c3a'>Total Cost Price: \"Style name\"</td>";
        echo "<td colspan='2' style='padding-top:10px; font-weight:bold; color:#cc1c3a'>$ " . number_format(round($total_inventories,2)) . "</td>";
        echo "</tr>";

        $total_all_inventories += $total_products;
        $total_all_price += $total_inventories;

        unset($ar_sizes);

        echo "</tr>";
        echo "<tr><td colspan='10' style='line-height: 30px;'>&nbsp;</td></tr>";
    }

    $total_all_price = number_format($total_all_price);
    $total_all_inventories = number_format($total_all_inventories);

    ?>
    </tbody>
</table>
</div>

<?php } ?>

<div id="divupload" style="position: fixed; top:0; left:0; padding: 20px 0; border-bottom: solid 1px #ccc; width: 100%; background: white; text-align: right;<?php echo $upload_display;?>">
    <form target="ifr" method="post" enctype="multipart/form-data" action="upload.php" onsubmit="return uploadNow()">
        Browse file <input type="file" name="file"/> <input type="submit" id="upload" value="Upload stitch excel" style="padding: 5px; margin-right: 20px;"/>
    </form>
    <iframe id="ifr" name="ifr" style="visibility: hidden;width:1px;height:1px;"></iframe>
    <span id="uploadmessage" style="margin-right: 20px;"></span>
</div>

<div id="divfilter" style="position: fixed; top:0; left:0; padding: 20px 0; border-bottom: solid 1px #ccc; width: 100%; background: white; text-align: right;<?php echo $filter_display;?>">
    <form action="index.php" method="get" id="frmfilter">
    <select name="store" style="padding: 5px;">
        <option value="all">All</option>
        <option value="brentwood">Brentwood</option>
        <option value="fallriver">Fall river</option>
        <option value="greenwich">Greenwich</option>
        <option value="magento">Magento</option>
    </select>
    <select id="products" style="display: inline; padding: 5px;">
        <?php
            foreach($product_names as $product){
                echo "<option>$product</option>";
            }
        ?>
    </select>
    <input type="button" id="search" value="Go to product" style="padding: 5px; margin-right: 5px;"/>
    <input type="button" style="padding:5px; margin-right: 20px;" id="showupload" value="Upload File"/>
    </form>

    <div style="float:left; padding-left: 20px;">
        <table style="width:600px;">
            <tr>
                <td style="width:200px;">Data for</td>
                <td style="width: 50px;">=</td>
                <td style="width:200px; color: red"><?php echo strtoupper($store);?></td>
            </tr>
            <tr>
                <td style="width:200px;">Total Inventory (Units)</td>
                <td>=</td>
                <td style="width:200px;"><?php echo $total_all_inventories;?></td>
            </tr>
            <tr>
                <td style="width:200px;">Total Cost of Inventory</td>
                <td>=</td>
                <td style="width:200px;">$ <?php echo round($total_all_price,2);?></td>
            </tr>
        </table>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    jQuery(function(){
        jQuery("#search").click(function(){
            var product = jQuery("#products").val();

           doSearch(product);
       });

        jQuery("#showupload").click(function(){
            jQuery("#divupload").show();
            jQuery("#divdata").hide();
            jQuery("#divfilter").hide();
        });

        jQuery("select[name='store']").change(function(){
            jQuery("#frmfilter").submit();
        });

        jQuery("select[name='store']").val("<?php echo $store;?>");
    });

    function uploadNow(){
        jQuery("#ifr").load(function(){
            jQuery("#uploadmessage").html("");

            var result = jQuery("#ifr").contents().find("body").html();

            if(result.indexOf('success')>-1)
                window.location.replace('index.php');
            else if(result.indexOf('large')>-1)
                jQuery("#uploadmessage").html("File was too large");
            else if(result.indexOf('error')>-1)
                jQuery("#uploadmessage").html("There was an error in file upload");
        });

        jQuery("#uploadmessage").html("Uploading...");

        return true;
    }

    function doSearch(text) {
        if (window.find && window.getSelection) {
            document.designMode = "on";
            var sel = window.getSelection();
            sel.collapse(document.body, 0);

            while (window.find(text)) {
                document.execCommand("HiliteColor", false, "yellow");
                sel.collapseToEnd();
            }
            document.designMode = "off";
        } else if (document.body.createTextRange) {
            var textRange = document.body.createTextRange();
            while (textRange.findText(text)) {
                textRange.execCommand("BackColor", false, "yellow");
                textRange.collapse(false);
            }
        }
    }
</script>

</body>
</html>

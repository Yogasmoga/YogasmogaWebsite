<?php
ob_start();

function hasDifferentSizes($originalSizes, $productSizes){

    foreach($productSizes as $productSize){

        $found = in_array($productSize, $originalSizes);

        if(!$found)
            return true;
    }

    return false;
}

$inputFileName = 'stitch.xls';

$upload_display = "display:none";
$filter_display = "display:none";

$stores = array('all', 'brentwood', 'fallriver', 'magento', 'greenwich');
$ar_sizes = array('One', 'S', 'M', 'L', 'XL', 'XXL', '2', '4', '6', '8', '10', '12', '14', '16', '18');

$store = 'all';
if (isset($_GET['store'])) {
    $store = strtolower($_GET['store']);

    if (!in_array($store, $stores))
        $store = 'total';
}
?>

<?php
if (file_exists($inputFileName)) {
    include 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

    $objTpl = new PHPExcel();
    $objTpl->setActiveSheetIndex(0);

    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        )
    );

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

        if (strpos($name, '(') === false)
            continue;

        $parenthesis_start_position = strpos($name, '(');
        $parenthesis_end_position = strpos($name, ')');

        $actual_name = trim(substr($name, 0, $parenthesis_start_position));
        $within_parenthesis = trim(substr($name, $parenthesis_start_position + 1, $parenthesis_end_position - $parenthesis_start_position - 1));

        if (strpos($within_parenthesis, ",") === false) {
            $color = $within_parenthesis;
            $size = 'One';
            $height = '';
        } else {
            $ar_within_parenthesis = explode(",", $within_parenthesis);
            $color = $ar_within_parenthesis[0];
            $size = $ar_within_parenthesis[1];

            if (count($ar_within_parenthesis) == 3)
                $height = $ar_within_parenthesis[2];
        }

        $product_names[] = $actual_name;

        $all_products[$actual_name][] = array(
            'name' => $actual_name,
            'color' => $color,
            'size' => $size,
            'height' => $height,
            'sku' => $sku,
            'unit_price' => round($unit_price, 2),
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
    <?php

    $total_all_inventories = 0;
    $total_inventories_cost = 0;
    $total_all_price = 0;

    $rowCount = 0;

    ++$rowCount;
    $objTpl->getActiveSheet()->setCellValue('A' . $rowCount, "Store = " . $store);
    $objTpl->getActiveSheet()->getStyle('A' . $rowCount)->applyFromArray(
        array(
            "font" => array(
                "bold" => true,
                'color' => array('rgb' => 'cc1c3a')
            )
        )
    );

    ++$rowCount;
    ++$rowCount;

    foreach ($all_products as $product_name => $data) {

        $styleName = $product_name;

        ++$rowCount;

        $objTpl->getActiveSheet()->setCellValue('A' . $rowCount, $product_name);
        $objTpl->getActiveSheet()->getStyle("A" . $rowCount . ":F" . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));

        $ar_color_size = array();
        $ar_color_sizes_name = array();

        // read all sizes of this product
        foreach($data as $ar)
            $ar_color_sizes_name[] = trim($ar['size']);

        $ar_color_sizes_name = array_unique($ar_color_sizes_name);
        sort($ar_color_sizes_name);
        $hasDifferentSize = hasDifferentSizes($ar_sizes, $ar_color_sizes_name);

        foreach ($data as $ar) {

            if (strlen(trim($ar['height'])) > 0) {
                $ar_color_size[$ar['color'] . '-' . $ar['height']][] = array(
                    'color' => $ar['color'] . '-' . $ar['height'],
                    'size' => trim($ar['size']),
                    'stock' => $ar[$store . '_stock'],
                    'unit_price' => $ar['unit_price']
                );
            } else {
                $ar_color_size[$ar['color']][] = array(
                    'color' => $ar['color'],
                    'size' => trim($ar['size']),
                    'stock' => $ar[$store . '_stock'],
                    'unit_price' => $ar['unit_price']
                );
            }
        }

        /***************** printing size header *********************/

        ++$rowCount;
        $objTpl->getActiveSheet()->setCellValue('A' . $rowCount, $product_name);

        $colNumber = 65;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 'Color');
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '2c62a5')
                )
            )
        );

        if($hasDifferentSize){
            foreach ($ar_color_sizes_name as $size) {

                ++$colNumber;
                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $size);
                $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
                    array(
                        "font" => array(
                            "bold" => true,
                            'color' => array('rgb' => 'FFFFFF')
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '2c62a5')
                        )
                    )
                );
            }
        }
        else {

            foreach ($ar_sizes as $size) {
                ++$colNumber;
                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $size);
                $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
                    array(
                        "font" => array(
                            "bold" => true,
                            'color' => array('rgb' => 'FFFFFF')
                        ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '2c62a5')
                        )
                    )
                );
            }

        }
        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 'Total Units');
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '2c62a5')
                )
            )
        );

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 'Cost Price');
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '2c62a5')
                )
            )
        );

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 'Total Cost Price');
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '2c62a5')
                )
            )
        );
        /***************** printing size header *********************/

        $total_products = 0;
        $total_inventories = 0;
        $ar_sub_total = array();
        $ar_sub_total_cost_price = array();
        $ar_sub_total_stock_sum = array();
        $sum_of_total = 0;
        $sum_of_inventories = 0;

        if($hasDifferentSize){
            foreach ($ar_color_size as $color_name_value => $color_data) {

                ++$rowCount;

                $colNumber = 65;
                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $color_name_value);

                $ar_size_stock = array();

                $total_product_stock = 0;
                foreach ($color_data as $color_size) {
                    if (isset($color_size['size']) && strlen(trim($color_size['size'])) > 0) {
                        $ar_size_stock[$color_size['size']] = $color_size['stock'];
                        $total_product_stock += $color_size['stock'];
                    }
                }

                $total_products += $total_product_stock;

                ksort($ar_size_stock);

                $x = 0;
                if(count($ar_size_stock)>0) {
                    $sub_total_stock_sum = 0;
                    foreach ($ar_color_sizes_name as $size) {

                        if(isset($ar_size_stock[$size])) {

                            $stock = $ar_size_stock[$size];
                            if (intval($stock) == 0) {
                                ++$colNumber;
                                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $stock);
                                $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            } else {
                                ++$colNumber;
                                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $stock);
                                $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            }

                            if (!isset($ar_sub_total_stock_sum[$size]))
                                $ar_sub_total_stock_sum[$size] = 0;

                            $ar_sub_total_stock_sum[$size] += $stock;
                        }
                        else{
                            if (!isset($ar_sub_total_stock_sum[$size]))
                                $ar_sub_total_stock_sum[$size] = 0;

                            ++$colNumber;
                            $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 0);
                            $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        }
                        ++$x;
                    }
                }

                // fill td's if there are not enough size available for this product
                if ($x > 0)
                    for ($i = $x; $i < count($ar_sizes); $i++) {
                        ++$colNumber;
                        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '');
                    }

                $sum_of_total = 0;
                $sum_of_inventories = 0;
                if (isset($color_data[0]['unit_price'])) {
                    ++$colNumber;
                    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $total_product_stock);
                    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $unit_price = $color_data[0]['unit_price'];

                    ++$colNumber;
                    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '$ ' . number_format($unit_price, 2, '.', ''));
                    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $net_total = $total_product_stock * $unit_price;
                    ++$colNumber;
                    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '$ ' . number_format($net_total, 2, '.', ''));
                    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $total_inventories_cost += $net_total;

                    $sum_of_total += $net_total;
                    $sum_of_inventories += $total_product_stock;
                }

                //$ar_sub_total_cost_price[] = $net_total;
            }
        }
        else {
            foreach ($ar_color_size as $color_name_value => $color_data) {

                ++$rowCount;

                $colNumber = 65;
                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $color_name_value);

                $ar_size_stock = array();

                $total_product_stock = 0;
                foreach ($color_data as $color_size) {
                    if (isset($color_size['size']) && strlen(trim($color_size['size'])) > 0) {
                        $ar_size_stock[$color_size['size']] = $color_size['stock'];
                        $total_product_stock += $color_size['stock'];
                    }
                }

                $total_products += $total_product_stock;

                ksort($ar_size_stock);

                $x = 0;
                if (count($ar_size_stock) > 0) {
                    $sub_total_stock_sum = 0;
                    foreach ($ar_sizes as $size) {

                        if (isset($ar_size_stock[$size])) {

                            $stock = $ar_size_stock[$size];
                            if (intval($stock) == 0) {
                                ++$colNumber;
                                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $stock);
                                $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            } else {
                                ++$colNumber;
                                $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $stock);
                                $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            }

                            if (!isset($ar_sub_total_stock_sum[$size]))
                                $ar_sub_total_stock_sum[$size] = 0;

                            $ar_sub_total_stock_sum[$size] += $stock;
                        } else {
                            if (!isset($ar_sub_total_stock_sum[$size]))
                                $ar_sub_total_stock_sum[$size] = 0;

                            ++$colNumber;
                            $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 0);
                            $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        }
                        ++$x;
                    }
                }

                // fill td's if there are not enough size available for this product
                if ($x > 0)
                    for ($i = $x; $i < count($ar_sizes); $i++) {
                        ++$colNumber;
                        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '');
                    }

                $sum_of_total = 0;
                $sum_of_inventories = 0;
                if (isset($color_data[0]['unit_price'])) {
                    ++$colNumber;
                    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $total_product_stock);
                    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $unit_price = $color_data[0]['unit_price'];

                    ++$colNumber;
                    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '$ ' . number_format($unit_price, 2, '.', ''));
                    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $net_total = $total_product_stock * $unit_price;
                    ++$colNumber;
                    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '$ ' . number_format($net_total, 2, '.', ''));
                    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $total_inventories_cost += $net_total;

                    $sum_of_total += $net_total;
                    $sum_of_inventories += $total_product_stock;
                }

                //$ar_sub_total_cost_price[] = $net_total;
            }
        }

        ++$rowCount;

        $colNumber = 65;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, 'Sub Total');
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => '2f70cc')
                )
            )
        );
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        foreach ($ar_sub_total_stock_sum as $size => $size_total) {
            ++$colNumber;
            $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $size_total);
            $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));
            $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }

        if(!$hasDifferentSize)
        for ($i = count($ar_sub_total_stock_sum); $i < count($ar_sizes); $i++) {
            ++$colNumber;
            $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '');
        }

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $total_products);
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '');
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, '$ ' . number_format($total_inventories_cost, 2, '.', ''));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        ++$rowCount;
        ++$rowCount;

        $colNumber = 65;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, "Total units: \"$styleName\"");
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => '2f70cc')
                )
            )
        );
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, round($total_products, 2));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $colNumber = 65;
        ++$rowCount;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, "Total Cost Price: \"$styleName\"");
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
            array(
                "font" => array(
                    "bold" => true,
                    'color' => array('rgb' => 'cc1c3a')
                )
            )
        );
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        ++$colNumber;
        $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, "$ " . number_format(round($total_inventories_cost, 2)));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(array("font" => array( "bold" => true)));
        $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $total_all_inventories += $total_products;
        $total_all_price += $total_inventories_cost;

        $total_inventories_cost = 0;

        ++$rowCount;
    }

    $total_all_price = number_format($total_all_price);
    $total_all_inventories = number_format($total_all_inventories);

/**************** showing total inventories ******************/
    $colNumber = 65;
    ++$rowCount;
    ++$rowCount;
    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, "Total Inventory (Units)");
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
        array(
            "font" => array(
                "bold" => true,
                'color' => array('rgb' => '2f70cc')
            )
        )
    );
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    ++$colNumber;
    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $total_all_inventories);
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
        array(
            "font" => array(
                "bold" => true,
                'color' => array('rgb' => 'cc1c3a')
            )
        )
    );
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

/**************** showing total inventories ******************/
    $colNumber = 65;
    ++$rowCount;
    ++$rowCount;
    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, "Total Cost of Inventory");
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
        array(
            "font" => array(
                "bold" => true,
                'color' => array('rgb' => '2f70cc')
            )
        )
    );
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    ++$colNumber;
    $objTpl->getActiveSheet()->setCellValue(chr($colNumber) . $rowCount, $total_all_price);
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->applyFromArray(
        array(
            "font" => array(
                "bold" => true,
                'color' => array('rgb' => 'cc1c3a')
            )
        )
    );
    $objTpl->getActiveSheet()->getStyle(chr($colNumber) . $rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    foreach(range('A','K') as $columnID) {
        $objTpl->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
    }

    ob_end_clean();

    header('Content-Type: application/vnd.ms-excel');
    header("Content-disposition: attachment; filename=\"formatted.xls\"");
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
    $objWriter->save('php://output');
    //$objWriter->save('formatted.xls');

//    $file_url = "formatted.xls";
//    header('Content-Type: application/vnd.ms-excel');
//    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
//    readfile($file_url);
}
?>
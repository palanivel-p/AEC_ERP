<?php
require_once '../../includes/excel_generator/PHPExcel.php';

Include("../../includes/connection.php");

$fdate1= $_GET['fdate'];
$ldate1= $_GET['ldate'];

$fdate_obj = new DateTime($fdate1);
$ldate_obj = new DateTime($ldate1);

$diff = $ldate_obj->diff($fdate_obj);


$diff_years_in_months = $diff->y * 12;
$total_diff_months = $diff_years_in_months + $diff->m;

if ($diff->d > 0) {
    $total_diff_months++;
}



$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Mark Baker")
    ->setLastModifiedBy("Mark Baker")
    ->setTitle("Product Wise Sales Report")
    ->setSubject("Product Wise Sales Report")
    ->setDescription("Product wise sales report generated using PHPExcel")
    ->setKeywords("phpexcel product sales report")
    ->setCategory("Sales Report");

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Wise Sales Report');
//$objPHPExcel->getActiveSheet()->mergeCells('A1:CZ1');


$objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
$objPHPExcel->getActiveSheet()->getStyle('A2:A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:A3')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A2:A3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
$objPHPExcel->getActiveSheet()->getStyle('B2:B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2:B3')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('B2:B3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
$objPHPExcel->getActiveSheet()->getStyle('C2:C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2:C3')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('C2:C3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
$objPHPExcel->getActiveSheet()->getStyle('D2:D3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D2:D3')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('D2:D3')->getFont()->setBold(true);


$objPHPExcel->getActiveSheet()->mergeCells('E2:E3');
$objPHPExcel->getActiveSheet()->getStyle('E2:E3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2:E3')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('E2:E3')->getFont()->setBold(true);

// Set the cell values
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Category');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Sub Category');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Product');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Customer');


$columnIndex = 5;
$currentDate = clone $fdate_obj;
//$finalColumnIndex = $columnIndex + ($total_diff_months * 3)+2;
for ($i = 0; $i < $total_diff_months; $i++) {

    $month_name = $currentDate->format('M');
    $year = $currentDate->format('Y');

    $formatted_date = $month_name . ' ' . substr($year, 2);

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, 2, $formatted_date); // Set the date header
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, 3, 'Qty'); // Set Qty
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex + 1, 3, 'Rate'); // Set Rate
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex + 2, 3, 'Amount'); // Set Amount

    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($columnIndex, 2, $columnIndex + 2, 2);

    $headerRowCount = 3;
    $textColor = '191b1f';
    $bgColor = 'c0ceeb';
    $borderColor = '000000';


    for ($col = $columnIndex; $col <= $columnIndex + 2; $col++) {
        for ($row = 1; $row <= $headerRowCount; $row++) {
            $cell = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setColor(new PHPExcel_Style_Color($textColor)); // Set text color
            $objPHPExcel->getActiveSheet()->getStyle($cell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($bgColor); // Set background color

            $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true)->setSize(14);
            $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            // Apply border
            $styleArray = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => $borderColor),
                    ),
                ),
            );
            $objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray($styleArray);
        }
    }

    $columnIndex += 3; // Move to the next set of columns for the next date
    $currentDate->modify('+1 month');
}

$finalColumnIndex = PHPExcel_Cell::stringFromColumnIndex($columnIndex);
$objPHPExcel->getActiveSheet()->mergeCells('A1:' . $finalColumnIndex . '1');
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $finalColumnIndex . '1')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $finalColumnIndex . '1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $finalColumnIndex . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


// Apply styling for the merged A1 header cell
$bgColorA1='ffff4d';
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($bgColorA1);

// Apply border for the merged A1 header cell
$styleArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => $borderColor),
        ),
    ),
);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);




$startCell = PHPExcel_Cell::stringFromColumnIndex($columnIndex) . '2';
$endCell = PHPExcel_Cell::stringFromColumnIndex($columnIndex) . '3';
$mergedCell = $startCell . ':' . $endCell;

$objPHPExcel->getActiveSheet()->mergeCells($mergedCell);

// Set header value in the top-left cell of the merged range
$objPHPExcel->getActiveSheet()->setCellValue($startCell, 'Grand Total');
$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($columnIndex))->setWidth(20);

for ($col = $columnIndex; $col <= $columnIndex; $col++) {
    for ($row = 1; $row <= $headerRowCount; $row++) {
        $cell = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setColor(new PHPExcel_Style_Color($textColor)); // Set text color
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($bgColor); // Set background color
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // Apply border
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => $borderColor),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray($styleArray);
    }
}




$currentDate = clone $fdate_obj;
$i = 0;
$columnIndexesa = 4;

$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
       $product_id=$row['product_id'];
        $currentDate = clone $fdate_obj;


        $sqlCus = "SELECT * FROM `customer`";
        $resultCus = mysqli_query($conn, $sqlCus);

        if (mysqli_num_rows($resultCus) > 0) {
            while ($rowCus = mysqli_fetch_assoc($resultCus)) {

                $customerIds = $rowCus['customer_id'];

                $sql1 = "SELECT * FROM `sale_details`,`sale` WHERE sale_details.sale_id=sale.sale_id AND sale_details.product_id='$product_id' AND sale_details.customer='$customerIds' AND sale.sale_date BETWEEN '$fdate1' AND '$ldate1'";

                $result1 = mysqli_query($conn, $sql1);

                if (mysqli_num_rows($result1) > 0) {
                    $row1 = mysqli_fetch_assoc($result1);
//                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        $currentDate = clone $fdate_obj;

                        $product_name=$row1['product_name'];
                        $sale_details_id = $row1['sale_details_id'];

                        $customer_id=$row1['customer'];

                        $sqlProduct = "SELECT * FROM `product` WHERE `product_id`='$product_id'";
                        $resProduct = mysqli_query($conn, $sqlProduct);
                        $rowProduct = mysqli_fetch_assoc($resProduct);
                        $product_name = $rowProduct['product_name'];
                        $primary_category = $rowProduct['primary_category'];
                        $sub_category = $rowProduct['sub_category'];
                        $product_price = $rowProduct['product_price'];

                        $sqlcustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                        $rescustomer = mysqli_query($conn, $sqlcustomer);
                        $rowcustomer = mysqli_fetch_assoc($rescustomer);
                        $customer_name = $rowcustomer['customer_name'];
                        // echo $customer_name."<br>";

                        $sqlcategory = "SELECT * FROM `category` WHERE `category_id`='$sub_category'";
                        $rescategory = mysqli_query($conn, $sqlcategory);
                        $rowcategory = mysqli_fetch_assoc($rescategory);
                        $category_name = $rowcategory['sub_category'];

                        $i++;

                        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3), $i);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3), $primary_category);
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3), $category_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3), $product_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3), $customer_name);
                        $columnIndexes = 5;

                        for ($a = 0; $a < $total_diff_months; $a++) {
                            $month_name = $currentDate->format('m');
                            $year = $currentDate->format('Y');
                            $years = intval($year);
                            $lastDate = getLastDateOfMonth($years, $month_name);

                            $fromD = date("Y-m-01",strtotime($currentDate->format('Y-m-d')));
                            $toD = date($lastDate,strtotime($currentDate->format('Y-m-d')));

                            $sql2 = "SELECT SUM(sale_details.qty) AS quantity,sale_details.unit_cost AS rate FROM `sale_details`,`sale` WHERE sale_details.sale_id=sale.sale_id  AND sale_details.product_id='$product_id' AND sale_details.customer='$customer_id' AND sale.sale_date BETWEEN '$fromD' AND '$toD'";

                            $result2 = mysqli_query($conn, $sql2);

                            if (mysqli_num_rows($result2) > 0) {

                                $row2 = mysqli_fetch_assoc($result2);

                                $quantity = $row2['quantity'] =NULL?0:$row2['quantity'];
                                $rate = $row2['rate']=NULL?0:$row2['rate'];
                                $amt = $quantity*$rate;

                                $bgColorQuantity = $quantity == 0 || $quantity == null || $quantity =='' ? 'ff4d4d' : '00b33c';
                                $bgColorRate =  $rate == 0 || $rate == null || $rate =='' ? 'ff4d4d' : '00b33c';
                                $bgColorAmt =  $amt == 0 || $amt == null || $amt =='' ? 'ff4d4d' : '00b33c';

                                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes, $columnIndexesa)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes, $columnIndexesa)->getFill()->getStartColor()->setRGB($bgColorQuantity);

                                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes + 1, $columnIndexesa)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes + 1, $columnIndexesa)->getFill()->getStartColor()->setRGB($bgColorRate);

                                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes + 2, $columnIndexesa)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes + 2, $columnIndexesa)->getFill()->getStartColor()->setRGB($bgColorAmt);

                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes, $columnIndexesa, $quantity); // Set Qty
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes + 1, $columnIndexesa, $rate); // Set Rate
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes + 2, $columnIndexesa, $amt); // Set Amount

                                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($columnIndexes, 2, $columnIndexes + 2, 2);

                                $columnIndexes += 3; // Move to the next set of columns for the next date


                            }else{
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes, $columnIndexesa, 0); // Set Qty
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes + 1, $columnIndexesa, 0); // Set Rate
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes + 2, $columnIndexesa, 0); // Set Amount

                                $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($columnIndexes, 2, $columnIndexes + 2, 2);

                                $columnIndexes += 3; // Move to the next set of columns for the next date
                            }


                            $totalAmount += $amt;
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndexes, $columnIndexesa, $totalAmount);
// Set background color for total amount based on condition
                            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes, $columnIndexesa)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnIndexes, $columnIndexesa)->getFill()->getStartColor()->setRGB($totalAmount == 0 || $totalAmount === null || $totalAmount === '' ? 'ff4d4d' : '00b33c');
                            $currentDate->modify('+1 month');


                        }
                        $totalAmount=0;
                        $columnIndexesa++;

//                    }
                }




            }

        }



    }
    }


// Set column widths
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
//$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);

//
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Apply background and text color
$textColor = '191b1f'; // #191b1f
$bgColor = 'c0ceeb'; // #c0ceeb

// Apply styles from column A to column Z
for ($col = 'A'; $col <= 'E'; $col++) {
    for ($row = 2; $row <= 3; $row++) {
        // Set text color
        $objPHPExcel->getActiveSheet()->getStyle($col . $row)->getFont()->setColor(new PHPExcel_Style_Color($textColor));

        // Set background color
        $objPHPExcel->getActiveSheet()->getStyle($col . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($bgColor);

        // Apply border color
        $borderColor = '000000'; // Dark black color

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => $borderColor),
                ),
            ),
        );

        $objPHPExcel->getActiveSheet()->getStyle($col . $row)->applyFromArray($styleArray);
    }
}


$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/Productwise_sale_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=Productwise_sale_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/Productwise_sale_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/Productwise_sale_report.csv');

function getLastDateOfMonth($years, $month) {
    $date = new DateTime("$years-$month-01");
    $date->modify('last day of this month');
    return $date->format('Y-m-d');
}

?>
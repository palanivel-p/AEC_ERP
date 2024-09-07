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
$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Category');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Sub Category');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Product');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Customer');

$columnIndex = 5;
$currentDate = clone $fdate_obj;

for ($i = 0; $i < $total_diff_months; $i++) {
    $month_name = $currentDate->format('M');
    $year = $currentDate->format('Y');

    $formatted_date = $month_name . ' ' . substr($year, 2);

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, 2, $formatted_date); // Set the date header
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, 3, 'Qty'); // Set Qty
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex + 1, 3, 'Rate'); // Set Rate
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex + 2, 3, 'Amount'); // Set Amount

    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($columnIndex, 2, $columnIndex + 2, 2);
    $columnIndex += 3; // Move to the next set of columns for the next date
    $currentDate->modify('+1 month');
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, 3, 'Grand Total'); // Set Grand Total





$currentDate = clone $fdate_obj;
$i = 0;
$columnIndexesa = 4;

$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id=$row['product_id'];
        $currentDate = clone $fdate_obj;

        $sql1 = "SELECT * FROM `sale_details`,`sale` WHERE sale_details.sale_id=sale.sale_id AND sale_details.product_id='$product_id' AND sale.sale_date BETWEEN '$fdate1' AND '$ldate1'";

        $result1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
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

//                    print_r($currentDate->format('Y-m-d'));

                    $fromD = date("Y-m-01",strtotime($currentDate->format('Y-m-d')));
                    $toD = date($lastDate,strtotime($currentDate->format('Y-m-d')));

//                    $sql2 = "SELECT SUM(sale_details.qty) AS quantity,sale_details.unit_cost AS rate FROM `sale_details`,`sale` WHERE sale_details.sale_id=sale.sale_id AND sale_details.product_id='$product_id' AND sale_details.customer='$customer_id' AND sale.sale_date BETWEEN '$fromD' AND '$toD'";
                    $sql2 = "SELECT SUM(sale_details.qty) AS quantity,sale_details.unit_cost AS rate FROM `sale_details`,`sale` WHERE sale_details.sale_id=sale.sale_id AND sale_details.sale_details_id='$sale_details_id' AND sale_details.product_id='$product_id' AND sale_details.customer='$customer_id' AND sale.sale_date BETWEEN '$fromD' AND '$toD'";

                    $result2 = mysqli_query($conn, $sql2);

                    if (mysqli_num_rows($result2) > 0) {

                        $row2 = mysqli_fetch_assoc($result2);

                        $quantity = $row2['quantity'] =NULL?0:$row2['quantity'];
                        $rate = $row2['rate']=NULL?0:$row2['rate'];
                        $amt = $quantity*$rate;

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



                    $currentDate->modify('+1 month');


                }

                $columnIndexesa++;

            }
        }
    }
}


// Set column widths
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
//$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);

// Set styles for heading cells
$objPHPExcel->getActiveSheet()->getStyle('A1:CZ1')->getFont()->setBold(true)->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A2:CZ2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:CZ2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3:CZ3')->getFont()->setBold(true);

// Apply background and text color
$textColor = '191b1f'; // #191b1f
$bgColor = 'c0ceeb'; // #c0ceeb

// Apply styles from column A to column Z
for ($col = 'A'; $col <= 'CZ'; $col++) {
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
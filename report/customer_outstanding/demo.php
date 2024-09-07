<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");
date_default_timezone_set("Asia/kolkata");
$p_name= $_GET['p_name'];
$p_code= $_GET['p_code'];
$s_category= $_GET['s_category'];
$p_category= $_GET['p_category'];
$brand= $_GET['brand'];
$customer= $_GET['customer'];

if($p_name != ""){
    $pNameSql= " AND product_name = '".$p_name."'";

}
else{
    $pNameSql ="";
}

if($p_code != ""){
    $pCodeSql= " AND product_code = '".$p_code."'";

}
else{
    $pCodeSql ="";
}

if($s_category != ""){
    $categorySql= " AND sub_category = '".$s_category."'";

}
else{
    $categorySql ="";
}
if($p_category != ""){
    $pcategorySql= " AND primary_category = '".$p_category."'";

}
else{
    $pcategorySql ="";
}

if($brand != ""){
    $brandSql= "AND brand_type = '".$brand."'";

}
else {
    $brandSql = "";
}
$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];

if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = '';
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";

    }
    else{
        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";

    }

}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Mark Baker")
    ->setLastModifiedBy("Mark Baker")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

// Add some data
$objPHPExcel->setActiveSheetIndex(0);

$currentDate = date('Y-m-d'); // Current date

$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Date');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Bill No');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Customer Name');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Total Amount');
$objPHPExcel->getActiveSheet()->setCellValue('F2', '30 to 45 days');
$objPHPExcel->getActiveSheet()->setCellValue('G2', '45 to 60 days');
$objPHPExcel->getActiveSheet()->setCellValue('H2', '60 to 90 days');
$objPHPExcel->getActiveSheet()->setCellValue('I2', '90 to 120 Days');
$objPHPExcel->getActiveSheet()->setCellValue('J2', '(>120 Days)');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Remarks');

$i = 0;

if($customer == "allname"){
    $sqlcus = "SELECT * FROM customer";
}else{
    $sqlcus = "SELECT * FROM customer Where customer_id='$customer'";
}

$resultcus = mysqli_query($conn, $sqlcus);
if (mysqli_num_rows($resultcus) > 0) {
    $overallTotal = 0;
    $overall30to45 = 0;
    $overall45to60 = 0;
    $overall60to90 = 0;
    $overall90to120 = 0;
    $overallGreaterThan120 = 0;
    while ($rowcus = mysqli_fetch_assoc($resultcus)) {

        $cus_id=$rowcus['customer_id'];



        $sql = "SELECT * FROM sale WHERE customer='$cus_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Initialize variables for overall totals

            while ($row = mysqli_fetch_assoc($result)) {

                $sale_id = $row['sale_id'];
//                echo $sale_id.'<br>';
                $customer_id = $row['customer'];
                $invoice_no = $row['invoice_no'];
                $remark = $row['notes'];
                $date = $row['sale_date'];
                $due_date = $row['due_date'];
                $sale_date = date('d-m-Y', strtotime($date));
                $due_date1 = date('d-m-Y', strtotime($due_date));

                // Calculate the difference in days
                $diffDays = (strtotime($currentDate) - strtotime($date)) / (60 * 60 * 24);

                // Fetch balance_amount
                $sqlamount = "SELECT SUM(pay_made) AS pay_made FROM sale_payment WHERE sale_id='$sale_id'";
                $resamount = mysqli_query($conn, $sqlamount);
                if (mysqli_num_rows($resamount) > 0) {
                    $arrayamount = mysqli_fetch_array($resamount);
                    $totalAmount = $arrayamount['pay_made'];
                }
                $grand_total = $row['grand_total'];
                $balance_amount = $grand_total - $totalAmount;

                // Assign remarks based on the difference in days
                if ($diffDays >= 30 && $diffDays <= 45) {
                    $column = 'F';
                } elseif ($diffDays > 45 && $diffDays <= 60) {
                    $column = 'G';
                } elseif ($diffDays > 60 && $diffDays <= 90) {
                    $column = 'H';
                } elseif ($diffDays > 90 && $diffDays <= 120) {
                    $column = 'I';
                } elseif ($diffDays > 120) {
                    $column = 'J';
                } else {
                    // Default column if the condition doesn't match
                    $column = '';
                }

                $sqlcustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                $rescustomer = mysqli_query($conn, $sqlcustomer);
                $rowcustomer = mysqli_fetch_assoc($rescustomer);
                $customer_name =  $rowcustomer['customer_name'];
                // Increment counter
                $i++;

                // Populate Excel sheet
                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), ($i));
                $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), ($due_date1));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), ($invoice_no));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2), ($customer_name));
                $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2), ($grand_total));

                // Set the value in the determined column
                if ($column != '') {

                    $objPHPExcel->getActiveSheet()->setCellValue($column . ($i + 2), $balance_amount);
                }

                if (empty($remark) || $remark === 0 || is_null($remark)) {
                    $remark1 = "NA";
                }else{
                    $remark1 = $remark;
                }

                $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 2), $remark1);

                // Update overall totals
                $overallTotal += $grand_total;
                if ($diffDays >= 30 && $diffDays <= 45) {
                    $overall30to45 += $balance_amount;
                } elseif ($diffDays > 45 && $diffDays <= 60) {
                    $overall45to60 += $balance_amount;
                } elseif ($diffDays > 60 && $diffDays <= 90) {
                    $overall60to90 += $balance_amount;
                } elseif ($diffDays > 90 && $diffDays <= 120) {
                    $overall90to120 += $balance_amount;
                } elseif ($diffDays > 120) {
                    $overallGreaterThan120 += $balance_amount;
                }

                // Align cell values to the left
                $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 2) . ':K' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }

    }
}


$overallRowIndex = $i + 3; // Assuming $i was your last row index
$objPHPExcel->getActiveSheet()->setCellValue('D' . $overallRowIndex, 'Overall Total');
$objPHPExcel->getActiveSheet()->setCellValue('E' . $overallRowIndex, $overallTotal);
$objPHPExcel->getActiveSheet()->setCellValue('F' . $overallRowIndex, $overall30to45);
$objPHPExcel->getActiveSheet()->setCellValue('G' . $overallRowIndex, $overall45to60);
$objPHPExcel->getActiveSheet()->setCellValue('H' . $overallRowIndex, $overall60to90);
$objPHPExcel->getActiveSheet()->setCellValue('I' . $overallRowIndex, $overall90to120);
$objPHPExcel->getActiveSheet()->setCellValue('J' . $overallRowIndex, $overallGreaterThan120);
$objPHPExcel->getActiveSheet()->setCellValue('K' . $overallRowIndex, '');


// Set the overall total row style
$overallTotalStyle = array(
    'font' => array('bold' => true, 'color' => array('rgb' => '000000')), // Black text color, bold
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'C6EFCE')), // Light green background color
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER) // Left-aligned text
);

// Apply the style to the overall total row
$objPHPExcel->getActiveSheet()->getStyle('A' . $overallRowIndex . ':K' . $overallRowIndex)->applyFromArray($overallTotalStyle);
ob_clean();
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('A1',"Customers Outstanding Report");
//$objPHPExcel->getActiveSheet()->setCellValue('A2');
$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2')
//    ->getAlignment()
//    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getFont()
    ->setSize(16)
    ->setBold(true);

//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2')
//    ->getFont()
//    ->setSize(13)
//    ->setBold(true);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:K1')
    ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
    );

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}

cellColor('A2:K2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:K2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:K2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/CustomerOutstanding_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=CustomerOutstanding_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/CustomerOutstanding_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/CustomerOutstanding_report.csv');

?>
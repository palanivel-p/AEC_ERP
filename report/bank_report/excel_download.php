<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

$bank_names= $_GET['bank_name'];

if($bank_name != ""){
    $bankName = $bank_names;
}
else{
    $bankName = $bank_names;
}
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d',strtotime($f_date));
$to_date = date('Y-m-d',strtotime($t_date));
$startDate = date("d-M-Y", strtotime($from_date));
$endDate = date("d-M-Y", strtotime($to_date));
if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
if($bank_names != ""){
//    $pNameSql= " AND product_name = '".$p_name."'";
    $bank_nameSql = " AND bank_name LIKE '%" . $bank_names . "%'";

}
else{
    $bank_nameSql ="";
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:H5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:H6');

$objPHPExcel->getActiveSheet()->setCellValue('A7', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B7', 'Date');
$objPHPExcel->getActiveSheet()->setCellValue('C7', 'Bank Name');
$objPHPExcel->getActiveSheet()->setCellValue('D7', 'Particulars');
$objPHPExcel->getActiveSheet()->setCellValue('E7', 'Payment Type');
$objPHPExcel->getActiveSheet()->setCellValue('F7', 'Reference No');
$objPHPExcel->getActiveSheet()->setCellValue('G7', 'Debit');
$objPHPExcel->getActiveSheet()->setCellValue('H7', 'Credit');

$i = 0;
$totalCredit = 0;
$totalDebit = 0;
if($bank_names == "" && $f_date =="" && $t_date =="") {
    $sql = "SELECT * FROM bank_details WHERE  payment_date  BETWEEN '$from_date' AND '$to_date' $bank_nameSql";
}
else {
    $sql = "SELECT * FROM bank_details WHERE  payment_date  BETWEEN '$from_date' AND '$to_date' $bank_nameSql";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;
        $bank_name=$row['bank_name'];
        $particular = $row['pay_from'];
        $payment_date = $row['payment_date'];
        $added_dates = date('d-m-Y', strtotime($payment_date));
        $pay_mode = $row['pay_mode'];
        $amount = $row['amount'];
        $ref_no = $row['ref_no'];
        $type = $row['type'];
        if (empty($type)) {
            $Credit = 'NA';
            $Debit = 'NA';
        } else {
            if ($type == 'Credit') {
                $Credit = $amount;
                $totalCredit += $amount;
                $Debit = 'NA'; // Optionally, you can set Debit to 'NA' if type is 'Credit'
            } elseif ($type == 'Debit') {
                $Debit = $amount;
                $totalDebit += $amount;
                $Credit = 'NA'; // Optionally, you can set Credit to 'NA' if type is 'Debit'
            } else {
                $Credit = 'NA';
                $Debit = 'NA';
            }
        }

        $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 7) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 7) , ($added_dates));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 7) , ($bank_name));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 7) ,$particular);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 7) ,$pay_mode);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 7) ,$ref_no);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 7) ,$Debit);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 7) ,$Credit);

    }
    $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 8), 'Total');
    $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 8), $totalDebit);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 8), $totalCredit);

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," ASSOCIATED  ENGINEERING COMPANY");
$objPHPExcel->getActiveSheet()->setCellValue('A2'," SF.NO.116/3 (B2)");
$objPHPExcel->getActiveSheet()->setCellValue('A3'," ANNUR ROAD, ARASUR VILLAGE");
$objPHPExcel->getActiveSheet()->setCellValue('A4'," SULUR TALUK");
$objPHPExcel->getActiveSheet()->setCellValue('A5'," COIMBATORE - 641 407.");
$objPHPExcel->getActiveSheet()->setCellValue('A6',  "  Bank Report - " . $startDate . " - " . $endDate);
// Adds a dash between the two dates
//$objPHPExcel->getActiveSheet()->setCellValue('A2');
$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:A6')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

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
    ->getStyle('A7:B1')
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

cellColor('A7:H7', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A7:H7')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A7:H7')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/bank_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=bank_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/bank_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/bank_report.csv');

?>
<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

$borrower_name= $_GET['b_name'];
$loan_id= $_GET['loan_id'];


if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
if($borrower_name != ""){
//    $pNameSql= " AND product_name = '".$p_name."'";
    $borrower_nameSql = " AND l.borrower LIKE '%" . $borrower_name . "%'";

}
else{
    $borrower_nameSql ="";
}

if($loan_id != ""){
//    $pCodeSql= " AND product_code = '".$p_code."'";
    $loan_idSql = " AND l.loan_id LIKE '%" . $loan_id . "%'";
}
else{
    $loan_idSql ="";
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Date');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Loan Id');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Borrower name');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Amount Paid');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Pay Mode');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Reference No');

$i = 0;
//$sql = "SELECT * FROM status ORDER BY id DESC";
$sql = "SELECT r.repayment_date, l.borrower, l.loan_id, r.repayment_amount, r.repayment_mode, r.reference_no, l.loan_date 
        FROM repayment r JOIN loan l ON r.loan_id = l.loan_id WHERE 1=1 $borrower_nameSql $loan_idSql ORDER BY l.loan_date DESC LIMIT $start, 10";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;
        $borrower = $row['borrower'];
        $loan_no = $row['loan_id'];
        $repayment_amount = $row['repayment_amount'];
        $repayment_mode = $row['repayment_mode'];
        $loan_date = $row['loan_date'];
        $dates = date('d-m-Y', strtotime($loan_date));
        $reference_no = $row['reference_no'];

        $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($dates));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($loan_no));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) , ($borrower));
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$repayment_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$repayment_mode);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$reference_no);

    }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1',"Loan-Repayment Report");
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
    ->getStyle('A2:B1')
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

cellColor('A2:G2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:F2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:G2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/loan_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=loan_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/loan_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/loan_report.csv');

?>
<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

$p_name= $_GET['p_name'];
$po_no= $_GET['po_no'];


if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
if($p_name != ""){
//    $pNameSql= " AND product_name = '".$p_name."'";
    $pNameSql = " AND product_name LIKE '%" . $p_name . "%'";

}
else{
    $pNameSql ="";
}

if($po_no != ""){
//    $pCodeSql= " AND product_code = '".$p_code."'";
    $poNoSql = " AND purchase_id LIKE '%" . $po_no . "%'";
}
else{
    $poNoSql ="";
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Bill No');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Po No');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Received Date');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Received Product');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Received Qty');

$i = 0;
$sql = "SELECT * FROM status ORDER BY id DESC";
if($po_no== "" && $p_name == "") {
    $sql = "SELECT * FROM status ORDER BY id DESC";
}
else {
    $sql = "SELECT * FROM status WHERE id > 0 $poNoSql$pNameSql";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;
        $bill_no=$row['bill_no'];
        $purchase_id = $row['purchase_id'];
        $status_date = $row['status_date'];
        $received_dates = date('d-m-Y', strtotime($status_date));
        $product_name = $row['product_name'];
        $material = $row['material'];

            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($bill_no));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($purchase_id));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$received_dates);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$product_name);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$material);

        }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," Purchase Status Report");
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

cellColor('A2:F2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:F2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:F2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/Purchase_status.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=Purchase_status.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/Purchase_status.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/adjustment_report.csv');

?>
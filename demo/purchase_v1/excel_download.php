<?php
require_once '../includes/excel_generator/PHPExcel.php';
Include("../includes/connection.php");

$p_id= $_GET['p_id'];
$s_id= $_GET['s_id'];

if($p_id != ""){
    $p_idSql= " AND purchase_id = '".$p_id."'";

}
else{
    $p_idSql ="";
}

if($s_id != ""){
    $s_idSql= " AND supplier = '".$s_id."'";

}
else{
    $s_idSql ="";
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Purchase Id');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Supplier');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Grand Total');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Payment Status');
//$objPHPExcel->getActiveSheet()->setCellValue('F2', 'password');
//$objPHPExcel->getActiveSheet()->setCellValue('G2', 'GSTIN');
//$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Address 1');
//$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Address 2');
//$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Place of supply');



$i = 0;

    if($s_id == "" && $p_id == "" ) {
        $sql = "SELECT * FROM purchase_v1 ";
    }
    else {
        echo  $sql = "SELECT * FROM purchase_v1 WHERE id > 0 $s_idSql$p_idSql";
    }
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {
        $status =  $row['payment_status'];
        if($status == 3){
            $payment_status = 'Pending';
        }
        else if($status == 1){
            $payment_status = 'Received';
        }
        else if($status == 2){
            $payment_status = 'partially Pending';
        }
        else if($status == 4){
            $payment_status = 'Ordered';
        }
        $sNo++;

        $supplier_id=$row['supplier'];
        $purchase_id=$row['purchase_id'];
        $grand_total=$row['grand_total'];

        $sqlSupplier = "SELECT * FROM `supplier` WHERE `supplier_id`='$supplier_id'";
        $resSupplier = mysqli_query($conn, $sqlSupplier);
        $rowSupplier = mysqli_fetch_assoc($resSupplier);
        $Supplier =  $rowSupplier['supplier_name'];
            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($purchase_id));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($Supplier));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$grand_total);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$payment_status);
//        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$supplier_email);
//        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$gstin);
//        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$address1);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2) ,$address2);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 2) ,$supply_place);


        }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," Purchase List");
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

cellColor('A2:E2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:E2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:E2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/purchase_v1.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=purchase_v1.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/purchase_v1.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/purchase_v1.csv');



?>
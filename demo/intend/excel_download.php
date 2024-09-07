<?php
require_once '../includes/excel_generator/PHPExcel.php';
Include("../includes/connection.php");

$pur_id= $_GET['pur_id'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];

if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
$to_date = date('Y-m-d 23:59:59',strtotime($t_date));
if($pur_id != ""){
    $pur_idSql= " AND intend_id = '".$pur_id."'";

}
else{
    $pur_idSql ="";
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
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Intend Id');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Intend Date');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Notes');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Added By');

//$objPHPExcel->getActiveSheet()->setCellValue('F2', 'password');
//$objPHPExcel->getActiveSheet()->setCellValue('G2', 'GSTIN');
//$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Address 1');
//$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Address 2');
//$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Place of supply');



$i = 0;

if($pur_id == "" ) {
    $sql = "SELECT * FROM intend WHERE intend_date  BETWEEN '$from_date' AND '$to_date' AND request = 1";
}
else {
    $sql = "SELECT * FROM intend WHERE intend_date  BETWEEN '$from_date' AND '$to_date' $pur_idSql AND request = 1";
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

        $intend_id=$row['intend_id'];
        $intend_date=$row['intend_date'];
        $int_date = date('d-m-Y', strtotime($intend_date));
//        $notes=$row['notes'];
//        $added_by=$row['added_by'];

        if($row['notes'] == ''){
            $notes = 'NA';
        }
        elseif ($row['notes']!= ''){
            $notes = $row['notes'];
        }
        if($row['added_by'] == ''){
            $added_by = 'Super Admin';
        }
        elseif ($row['added_by']!= ''){
            $added_by = $row['added_by'];
        }
            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($intend_id));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($int_date));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$notes);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$added_by);
//        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$supplier_email);
//        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$gstin);
//        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$address1);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2) ,$address2);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 2) ,$supply_place);


        }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," Intent List");
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
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/intend.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=intend.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/intend.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/intend.csv');



?>
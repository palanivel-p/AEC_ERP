<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

$user_name= $_GET['u_name'];
$role= $_GET['user_role'];


if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
if($user_name != ""){
//    $pNameSql= " AND product_name = '".$p_name."'";
    $user_nameSql = " AND user_name LIKE '%" . $user_name . "%'";

}
else{
    $user_nameSql ="";
}

if($role != ""){
//    $pCodeSql= " AND product_code = '".$p_code."'";
    $roleSql = " AND role LIKE '%" . $role . "%'";
}
else{
    $roleSql ="";
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

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer Name');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Meet Person');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Reschedule Date');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Note');


$i = 0;
$sql = "SELECT * FROM marketing WHERE `type` = 'reschedule' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;
        $customer_name=$row['customer_name'];
        $meet_person = $row['meet_person'];
        $next_date = $row['next_date'];
        $next_dates = date('d-m-Y', strtotime($next_date));
        $notes = $row['notes'];

        $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($customer_name));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($meet_person));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$next_dates);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$notes);

    }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," Reschedule Report");
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
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/reschedule_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=reschedule_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/reschedule_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/reschedule_report.csv');

?>
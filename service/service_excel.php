<?php
require_once '../includes/excel_generator/PHPExcel.php';
Include("../includes/connection.php");

$product_id= $_GET['product_id'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];

if($product_id != ""){
//    $product_idSql= " AND material_name LIKE '%".$product_id."%'";
    $product_idSql= " AND customer_name = '".$product_id."'";
}
else{
    $product_idSql ="";
}
if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
$to_date = date('Y-m-d 23:59:59',strtotime($t_date));

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

$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Visit Date');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Customer Name');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Meet whom');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Mobile');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Discuss About');
//$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Progress');




$i = 0;

if($product_id == "") {
    $sql = "SELECT * FROM service WHERE visit_date  BETWEEN '$from_date' AND '$to_date'";
}
{
    $sql = "SELECT * FROM service WHERE visit_date  BETWEEN '$from_date' AND '$to_date' $product_idSql";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;

        $v_date = $row['visit_date'];
        $visite_date = date('d-m-Y', strtotime($v_date));

        $customer_id=$row['customer_name'];
        $sqlCustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
        $resCustomer = mysqli_query($conn, $sqlCustomer);
        $rowCustomer = mysqli_fetch_assoc($resCustomer);
        $customer_name =  $rowCustomer['customer_name'];
        $meet_whom=$row['meet_whom'];
        $mobile =  $row['mobile'];
        $discuss_about =  $row['discuss_about'];
//        $progress =  $row['progress'];

        $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($visite_date));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($customer_name));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$meet_whom);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$mobile);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$discuss_about);
//        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$progress);
//        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$address1);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2) ,$address2);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 2) ,$supply_place);


    }

}


//table two
$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B', 'Test');
$objPHPExcel->getActiveSheet()->setCellValue('C', 'Test Name');
$objPHPExcel->getActiveSheet()->setCellValue('D', 'Meet Test');
$objPHPExcel->getActiveSheet()->setCellValue('E', 'Test Mobile');
$objPHPExcel->getActiveSheet()->setCellValue('F', 'Test About');
//$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Progress');




$i = 0;

if($Test_id == "") {
    $sql = "SELECT * FROM Test WHERE Test_date  BETWEEN '$Test_date' AND '$Test_date'";
}
{
    $sql = "SELECT * FROM Test WHERE Test_date  BETWEEN '$Test_date' AND '$Test_date' $Test_idSql";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;

        $v_date = $row['Test_date'];
        $visite_date = date('d-m-Y', strtotime($v_date));

        $customer_id=$row['customer_name'];
        $sqlCustomer = "SELECT * FROM `Test` WHERE `Test_id`='$Test_id'";
        $resCustomer = mysqli_query($conn, $sqlCustomer);
        $rowCustomer = mysqli_fetch_assoc($resCustomer);
        $customer_name =  $rowCustomer['Test_name'];
        $meet_whom=$row['meet_Test'];
        $mobile =  $row['Testmobile'];
        $discuss_about =  $row['Test_about'];
//        $progress =  $row['progress'];

        $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A'  , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' , ('test'));
        $objPHPExcel->getActiveSheet()->setCellValue('C'  , ('test'));
        $objPHPExcel->getActiveSheet()->setCellValue('D'  ,'test');
        $objPHPExcel->getActiveSheet()->setCellValue('E'  ,'test');
        $objPHPExcel->getActiveSheet()->setCellValue('F'  ,'test');

    }

}
ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," service List");
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
    ->getStyle('A2:G2')
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
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/service.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=service.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/service.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/service.csv');



?>
<?php
require_once '../includes/excel_generator/PHPExcel.php';
Include("../includes/connection.php");

$c_no= $_GET['c_no'];
$b_name = $_GET['b_name'];
$acc_no = $_GET['acc_no'];


if($c_no != ""){
    $c_noSql= " AND category_id = '".$c_no."'";

}
else{
    $c_noSql ="";
}

if($b_name != ""){
    $b_nameSql= " AND primary_category = '".$b_name."'";

}
else{
    $b_nameSql ="";
}

if($acc_no != ""){
    $acc_noSql= " AND sub_category = '".$acc_no."'";

}
else{
    $acc_noSql ="";
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Purchase Id');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Delivery challan Id');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Dispatched Through');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Destination');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Vehicle No');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Delivery challan Date');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Delivery Date');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Shipment Amount');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Other Charges');



$i = 0;
$sql = "SELECT * FROM purchase_shipment";
//if($acc_no == "" && $b_name == "" && $c_no == "") {
//    $sql = "SELECT * FROM cheque";
//}
//else {
//    $sql = "SELECT * FROM cheque WHERE id>0 $acc_noSql$b_nameSql$c_noSql";
//}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;

        $purchase_id =$row['purchase_id'];
        $shipping_id =$row['shipping_id'];
        $dispatched_through =$row['dispatched_through'];
        $destination =$row['destination'];
        $vehicle_no =$row['vehicle_no'];
        $date =$row['date'];
        $shipment_date = date('d-m-Y', strtotime($date));
        $d_date =$row['delivery_date'];
        $delivery_date = date('d-m-Y', strtotime($d_date));
        $shipping_amount =$row['shipping_amount'];
        $other_charges =$row['other_charges'];


            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($purchase_id));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($shipping_id));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$dispatched_through);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$destination);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$vehicle_no);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$shipment_date);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$delivery_date);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2) ,$shipping_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 2) ,$other_charges);


        }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," Purchase Delivery challan ");
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

cellColor('A2:J2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:J2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:J2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/Purchase_shipment.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=Purchase_shipment.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/Purchase_shipment.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/Purchase_shipment.csv');



?>
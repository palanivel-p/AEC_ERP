<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

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

$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Request Date');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Material');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Quantity');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Remarks');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Received Date');

$i = 0;

//if($pur_id == "" ) {
//    // $sql = "SELECT * FROM purchase  ORDER BY id  LIMIT $start,10";
//    $sql = "SELECT * FROM purchase_details WHERE purchase_date  BETWEEN '$from_date' AND '$to_date' ORDER BY id DESC LIMIT $start, 10";
//
//}
//else {
//    $sql = "SELECT * FROM purchase_details WHERE purchase_date  BETWEEN '$from_date' AND '$to_date' $pur_idSql  ORDER BY id DESC LIMIT $start,10";
//}
//$result = mysqli_query($conn, $sql);
//if (mysqli_num_rows($result)>0) {
//    $sNo = $i;
//    while($row = mysqli_fetch_assoc($result)) {
//
//        $sNo++;
//
//
//        $date = $row['purchase_date'];
//        $purchase_date = date('d-m-Y', strtotime($date));
//
//        $product_name = $row['product_name'];
//        $qty = $row['qty'];
//
//        $dates = $row['material_date'];
//        $material_date = date('d-m-Y', strtotime($dates));
//        if($row['notes'] == ''){
//            $notes = 'NA';
//        }
//        elseif ($row['notes']!= ''){
//            $notes = $row['notes'];
//        }
//
//            $i++;
//
//        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
//        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($purchase_date));
//        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($product_name));
//        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$qty);
//        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$notes);
//        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$material_date);
//
//        }
//
//}
$sql = "SELECT DATE_FORMAT(i.intend_date,'%d-%m-%Y') intend_date,id.product_name,id.qty,(case when DATE_FORMAT(p.material_date,'%d-%m-%Y') is not null then DATE_FORMAT(p.material_date,'%d-%m-%Y') else '-' end) material_date,(case when p.status is not null then p.status else '-' end) status1 FROM intend i inner join intend_details id on id.intend_id=i.intend_id left join purchase p on i.intend_id=p.intend_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $sNo = 0; // Initialize $sNo here
    while ($row = mysqli_fetch_assoc($result)) {
        $sNo++; // Increment $sNo here
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $qty = $row['qty'];
        $intend_date=$row['intend_date'];
        $status1=$row['status1'];
        $material_date=$row['material_date'];

        $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($intend_date));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($product_name));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$qty);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$status1);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$material_date);

    }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1',"Material Requesting Details");
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
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/Intend_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=Intend_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/Intend_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/Intend_report.csv');

?>
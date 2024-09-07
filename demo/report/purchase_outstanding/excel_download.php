<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

$p_name= $_GET['p_name'];
$p_code= $_GET['p_code'];
$s_category= $_GET['s_category'];
$p_category= $_GET['p_category'];
$brand= $_GET['brand'];

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

$objPHPExcel->getActiveSheet()->mergeCells('F1:H1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('F2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Suppliers');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Amount');


$i = 0;

//if($brand == "" && $p_code == "" && $s_category== "" && $p_category == ""&& $p_name == "") {
//    $sql = "SELECT * FROM product";
//}
//else {
//    $sql = "SELECT * FROM product WHERE id > 0 $brandSql$categorySql$pCodeSql$pNameSql$pcategorySql";
//}
$sql = "SELECT * FROM purchase";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;


        $purchase_id =  $row['purchase_id'];
        $supplier_id =  $row['supplier'];


        $sqlamount="SELECT SUM(pay_made) AS pay_made  FROM purchase_payment WHERE purchase_id='$purchase_id'";
        $resamount=mysqli_query($conn,$sqlamount);
        if(mysqli_num_rows($resamount)>0){
            $arrayamount=mysqli_fetch_array($resamount);
            $totalAmount=$arrayamount['pay_made'];
        }
        $grand_total= $row['grand_total'];
        $balance_amount= $grand_total - $totalAmount;
        $overallTotalAmount += $balance_amount;
        $sqlSupplier = "SELECT * FROM `supplier` WHERE `supplier_id`='$supplier_id'";
        $resSupplier= mysqli_query($conn, $sqlSupplier);
        $rowSupplier= mysqli_fetch_assoc($resSupplier);
        $supplier_name =  $rowSupplier['supplier_name'];

            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) , ($supplier_name));
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) , ($balance_amount));
        $objPHPExcel->getActiveSheet()->getStyle('F' . ($i + 2) . ':H' . ($i + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    }

    // Insert overall total amount after the loop
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2), "Overall Total");
    $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2), $overallTotalAmount);
}
$overallTotalStyle = array(
    'font' => array('bold' => true, 'color' => array('rgb' => '000000')), // Black text color, bold
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'C6EFCE')), // Light green background color
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT) // Left-aligned text
);

// Apply the overall total style to the "Overall Total" row
$objPHPExcel->getActiveSheet()->getStyle('F' . ($i + 2) . ':H' . ($i + 2))->applyFromArray($overallTotalStyle);

ob_clean();
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('F1',"AEC Purchase Outstanding Report");
//$objPHPExcel->getActiveSheet()->setCellValue('A2');
$objPHPExcel->getActiveSheet()
    ->getStyle('F1')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2')
//    ->getAlignment()
//    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()
    ->getStyle('F1')
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
    ->getStyle('F2:H1')
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

cellColor('F2:H2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('F2:H2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('F2:H2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/PurchaseOutstanding_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=PurchaseOutstanding_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/PurchaseOutstanding_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/PurchaseOutstanding_report.csv');

?>
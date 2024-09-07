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

$objPHPExcel->getActiveSheet()->mergeCells('F1:K1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('F2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Date-month');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Product');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Quantity');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Inv No');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Remark');


$i = 0;

//if($brand == "" && $p_code == "" && $s_category== "" && $p_category == ""&& $p_name == "") {
//    $sql = "SELECT * FROM product";
//}
//else {
//    $sql = "SELECT * FROM product WHERE id > 0 $brandSql$categorySql$pCodeSql$pNameSql$pcategorySql";
//}
$sql = 'select notes,s.sale_id,invoice_no,sd.product_id,max(CONVERT(s.sale_date, DATE)) maxsaledate,DATE_FORMAT(max(CONVERT(s.sale_date, DATE)),"%d-%m-%Y") maxsale_date,qty,stock_qty,p.product_name from sale s inner join sale_details sd on s.sale_id=sd.sale_id inner join product p on p.product_id=sd.product_id group by sd.product_id HAVING max(CONVERT(s.sale_date, DATE))<CONVERT(NOW() - INTERVAL 4 MONTH, DATE)';
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $sNo = 0; // Initialize $sNo here
    while ($row = mysqli_fetch_assoc($result)) {
        $sNo++; // Increment $sNo here
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $qty = $row['stock_qty'];
        $date=$row['maxsale_date'];
        $invno=$row['invoice_no'];
        $remark=$row['notes'];

        // Assuming $objPHPExcel is already defined somewhere in your code
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($sNo + 2), ($sNo));
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($sNo + 2), ($date));
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($sNo + 2), ($product_name));
        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($sNo + 2), ($qty));
        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($sNo + 2), ($invno));
        $objPHPExcel->getActiveSheet()->setCellValue('K' . ($sNo + 2), ($remark));
    }
}


ob_clean();
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('F1',"Last 120 Days Non-Moving Product Report");
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
    ->getStyle('F2:K1')
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

cellColor('F2:K2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('F2:K2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('F2:K2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/Non_moving_product_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=Non_moving_product_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/Non_moving_product_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/Non_moving_product_report.csv');

?>
<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");

$p_name= $_GET['p_name'];
$p_code= $_GET['p_code'];
$s_category= $_GET['s_category'];
$p_category= $_GET['p_category'];

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

if($p_code != ""){
//    $pCodeSql= " AND product_code = '".$p_code."'";
    $pCodeSql = " AND product_code LIKE '%" . $p_code . "%'";
}
else{
    $pCodeSql ="";
}

if($s_category != ""){
//    $categorySql= " AND sub_category = '".$s_category."'";
    $categorySql = " AND sub_category LIKE '%" . $s_category . "%'";
}
else{
    $categorySql ="";
}
if($p_category != ""){
//    $pcategorySql= " AND primary_category = '".$p_category."'";
    $pcategorySql = " AND primary_category LIKE '%" . $p_category . "%'";
}
else{
    $pcategorySql ="";
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
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Name');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Primary Category');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Sub Category');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Stock');

$i = 0;

if($s_category== "" && $p_category == ""&& $p_name == "") {
    $sql = "SELECT * FROM product";
}
else {
    $sql = "SELECT * FROM product WHERE id > 0 $categorySql$pNameSql$pcategorySql";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;


        $product_name =  $row['product_name'];
        $product_id =  $row['product_id'];
        $stock =  $row['stock_qty'];
        $primary_category =  $row['primary_category'];
        $sub_category =  $row['sub_category'];
        $product_unit =  $row['product_unit'];

        $sqlcategory = "SELECT * FROM `category` WHERE `category_id`='$sub_category'";
        $rescategory= mysqli_query($conn, $sqlcategory);
        $rowcategory = mysqli_fetch_assoc($rescategory);
        $category_name =  $rowcategory['sub_category'];

            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($product_name));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($primary_category));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$category_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$stock);

        }

}

ob_clean();
$objPHPExcel->getActiveSheet()->setCellValue('A1'," Product Stock List");
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
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/product-stock.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=product.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/product-stock.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/product-stock.csv');

?>
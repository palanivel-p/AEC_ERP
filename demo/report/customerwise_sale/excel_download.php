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
//Columns merging
$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
$objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
$objPHPExcel->getActiveSheet()->mergeCells('J2:J3');
$objPHPExcel->getActiveSheet()->mergeCells('K2:K3');
$objPHPExcel->getActiveSheet()->mergeCells('L2:L3');

$objPHPExcel->getActiveSheet()->setCellValue('A2', 'S.No');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer Name');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Product Name');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Dec-23');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Sum of QTY');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Dec-23');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Average of RATE');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Dec-23');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Sum of AMT');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Jan-24');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Sum of QTY');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Jan-24');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Average of RATE');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Jan-24');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Sum of AMT');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Total Sum of QTY');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Total Average of RATE');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Total Sum of AMT');


$i = 0;

//if($brand == "" && $p_code == "" && $s_category== "" && $p_category == ""&& $p_name == "") {
//    $sql = "SELECT * FROM product";
//}
//else {
//    $sql = "SELECT * FROM product WHERE id > 0 $brandSql$categorySql$pCodeSql$pNameSql$pcategorySql";


$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $sNo = 0; // Initialize $sNo here
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_price = $row['product_price'];

        $sqlSale = "SELECT * FROM `sale_details` WHERE `product_id`='$product_id'";
        $resultSale = mysqli_query($conn, $sqlSale);

        if (mysqli_num_rows($resultSale) > 0) {
            while ($rowsale_details = mysqli_fetch_assoc($resultSale)) {
//            $rowsale_details = mysqli_fetch_assoc($resultSale);
            $customer_id = $rowsale_details['customer'];
            $qty = $rowsale_details['qty'];
                $sumamount = $qty*$product_price;
            $sNo++; // Increment $sNo here
            $sqlProduct = "SELECT * FROM `product` WHERE `product_id`='$product_id'";
            $resProduct = mysqli_query($conn, $sqlProduct);
            $rowProduct = mysqli_fetch_assoc($resProduct);
            $product_name = $rowProduct['product_name'];
//        $qty = $rowProduct['stock_qty'];
            $primary_category = $rowProduct['primary_category'];
            $sub_category = $rowProduct['sub_category'];

//        $sale_id = $row['sale_id'];
//        $sqlamount = "SELECT SUM(pay_made) AS pay_made  FROM sale_payment WHERE sale_id='$sale_id'";
//        $resamount = mysqli_query($conn, $sqlamount);
//        if (mysqli_num_rows($resamount) > 0) {
//            $arrayamount = mysqli_fetch_array($resamount);
//            $totalAmount = $arrayamount['pay_made'];
//        }
//        $grand_total = $row['grand_total'];
//        $balance_amount = $grand_total - $totalAmount;

            $sqlcustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
            $rescustomer = mysqli_query($conn, $sqlcustomer);
            $rowcustomer = mysqli_fetch_assoc($rescustomer);
            $customer_name = $rowcustomer['customer_name'];

            $i++;
                $objPHPExcel->getActiveSheet()
                    ->getStyle('A','L')
                    ->getAlignment()
                    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3), ($i));
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3), ($customer_name));
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3), ($product_name));
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3), ($qty));
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3), ($product_price));
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3), ($sumamount));
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3), ($product_price));
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3), ($sumamount));
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3), ($balance_amount));
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3), ($balance_amount));
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 3), ($balance_amount));
            $objPHPExcel->getActiveSheet()->setCellValue('L' . ($i + 3), ($balance_amount));
        }
    }
        }

}

ob_clean();
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$headingFontStyle = [
    'font' => [
        'bold' => true, // Make the font bold
        'size' => 12, // Set the font size
        // Add any other font properties if needed
    ],
];

// Apply font style to the heading cells
$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($headingFontStyle);
$objPHPExcel->getActiveSheet()->getStyle('D3:L3')->applyFromArray($headingFontStyle);
// Define your desired text color and background color
$textColor = '191b1f'; // #c0ceeb
$bgColor = 'c0ceeb'; // #191b1f

// Loop through each cell in the specified range and set the styles
for ($col = 'A'; $col <= 'L'; $col++) {
    for ($row = 2; $row <= 3; $row++) {
        // Set text color
        $objPHPExcel->getActiveSheet()->getStyle($col . $row)->getFont()->setColor(new PHPExcel_Style_Color($textColor));

        // Set background color
        $objPHPExcel->getActiveSheet()->getStyle($col . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($col . $row)->getFill()->getStartColor()->setARGB($bgColor);

    }
}
$styleA1 = array(
    'font' => array(
        'bold' => true, // Set bold font
        'size' => 14 // Set font size
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT // Set text alignment to left
    )
);

// Apply the style to cell A1
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleA1);


////$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('A1',"Customer Wise sale Report");
$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
//
////$objPHPExcel->getActiveSheet()
////    ->getStyle('A2')
////    ->getAlignment()
////    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
//
//$objPHPExcel->getActiveSheet()
//    ->getStyle('A1')
//    ->getFont()
//    ->setSize(16)
//    ->setBold(true);
//
////$objPHPExcel->getActiveSheet()
////    ->getStyle('A2')
////    ->getFont()
////    ->setSize(13)
////    ->setBold(true);
//
//
//// Rename worksheet
//$objPHPExcel->getActiveSheet()->setTitle('Simple');
//
//$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2:O1')
//    ->getProtection()->setLocked(
//        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
//    );
//
//function cellColor($cells,$color){
//    global $objPHPExcel;
//
//    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
//        'type' => PHPExcel_Style_Fill::FILL_SOLID,
//        'startcolor' => array(
//            'rgb' => $color
//        )
//    ));
//}
//
//cellColor('A2:O2', '#bccbeb');
//cellColor('A3:O3', '#bccbeb');
//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2:O2')
//    ->getFont()
//    ->getColor()
//    ->setRGB('181f5a');
//
//$objPHPExcel->getActiveSheet()
//    ->getStyle('A3:O3')
//    ->getFont()
//    ->getColor()
//    ->setRGB('181f5a');
//
//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2:O2')
//    ->getFont()
//    ->setSize(12)
//    ->setBold(true);
//
//$objPHPExcel->getActiveSheet()
//    ->getStyle('A3:O3')
//    ->getFont()
//    ->setSize(12)
//    ->setBold(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/CustomerWise_sale_report.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=CustomerWise_sale_report.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/CustomerWise_sale_report.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/CustomerWise_sale_report.csv');

?>
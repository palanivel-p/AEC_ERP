<?php
require_once '../../includes/excel_generators/PHPExcel.php';
Include('../../includes/connection.php');

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

$search= $_GET['search'];
$fdate = $_GET['from'];
$ldate = $_GET['to'];

if($fdate == ''){
    $fdate = date('Y-m-01');
}
if($ldate == ''){
    $ldate = date('Y-m-d');
}

$from = date('Y-m-d 00:00:00',strtotime($fdate));

$to = date('Y-m-d 23:59:59',strtotime($ldate));


//Create new PHPExcel object
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



$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');



$objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
//$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Visitor ID');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Name');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Mobile');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Company');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Purpose');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'To employee');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Entry');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Exit');
//$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Part 4');
//$objPHPExcel->getActiveSheet()->setCellValue('K3', 'Box No');

$i = 0;


if($search=="") {
    $sqlquery = "SELECT * FROM visitor_details WHERE `visit_dt` BETWEEN '$from' AND '$to'";
}else{
    $sqlquery = "SELECT * FROM visitor_details WHERE name LIKE '%$search%' AND `visit_dt` BETWEEN '$from' AND '$to'";
}


$result = mysqli_query($conn, $sqlquery);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $to_person_id =  $row['to_emp_id'];

        $sqlqueryss = "select * from staff where staff_id='$to_person_id'";
        $resultss = mysqli_query($conn, $sqlqueryss);

        $rows = mysqli_fetch_array($resultss);

        $sNo++;



        $name = $row['name'];
        $visitor_id = $row['visitor_id'];
        $mobile =  $row['mobile'];
//        $date =  $row['visit_dt'];
        $company =  $row['company'];
        $purpose =  $row['purpose'];
        $to_emp_id =  $rows['staff_name'];
        $originalDateTime = $row['visit_dt'];
        $formattedDate = date("d-m-Y", strtotime($originalDateTime));
        $formattedTime = date("h:i A", strtotime($originalDateTime));
        $visit_dt = $formattedDate . ' ' . $formattedTime;

        $originalDateTime = $row['exit_dt'];
        if($originalDateTime=="0000-00-00 00:00:00"){
            $exit_dt="NA";
        }else{
            $formattedDate = date("d-m-Y", strtotime($originalDateTime));
            $formattedTime = date("h:i A", strtotime($originalDateTime));
            $exit_dt = $formattedDate . ' ' . $formattedTime;
        }


//        $scan_4 =  $row['scan_4'];
//        $box_code =  $row['box_code'];





        $i++;



        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3) , ($i));
//        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3) ,$visitor_id);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3) ,$name);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3) ,$mobile);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3) ,$company);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3) ,$purpose);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3) ,$to_emp_id);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3) ,$visit_dt);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3) ,$exit_dt);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3) ,$scan_3);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3) ,$scan_4);
//        $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 3) ,$box_code);



    }

}

//echo $_SERVER["DOCUMENT_ROOT"];



$objPHPExcel->getActiveSheet()->setCellValue('A1'," Report");
$objPHPExcel->getActiveSheet()->setCellValue('A2');
$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));



$objPHPExcel->getActiveSheet()
    ->getStyle('A2')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));



$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getFont()
    ->setSize(16)
    ->setBold(true);



$objPHPExcel->getActiveSheet()
    ->getStyle('A2')
    ->getFont()
    ->setSize(13)
    ->setBold(true);





// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');



$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:B2')
    ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
    );function cellColor($cells,$color){
    global $objPHPExcel;



    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}



cellColor('A3:O3', '#181f5a');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:O3')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:O3')
    ->getFont()
    ->setSize(12)
    ->setBold(true);



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/hrms/visitors/visitor_details_log.xlsx');
sleep(1);

ob_end_clean();


header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=visitor_details_log.xlsx");
readfile($_SERVER["DOCUMENT_ROOT"].'/hrms/visitors/visitor_details_log.xlsx');



@unlink($_SERVER["DOCUMENT_ROOT"].'/hrms/visitors/visitor_details_log.xlsx');



?>
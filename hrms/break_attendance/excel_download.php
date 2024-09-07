<?php
require_once '../../includes/excel_generators/PHPExcel.php';
Include('../../includes/connection.php');


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



$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');



$objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Employee ID');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Date & Time');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'BreakOut');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'BreakIn');
//$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Status');
//$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Part 1');
//$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Part 2');
//$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Part 3');
//$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Part 4');
//$objPHPExcel->getActiveSheet()->setCellValue('K3', 'Box No');

$i = 0;


if( $search=="") {
    $sqlquery = "SELECT * FROM break_attendance WHERE `date` BETWEEN '$from' AND '$to' ";
}else{
      $sqlquery = "SELECT * FROM break_attendance WHERE emp_id='$search' AND `date` BETWEEN '$from' AND '$to'";
}

$result = mysqli_query($conn, $sqlquery);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {



        $sNo++;



//        $name =  $row['name'];
        $employee_id =  $row['emp_id'];


//        $shift =  $row['shift'];
          $date =  $row['date'];
//        $breakin =  $row['break_out'];
//        $breakout =  $row['break_in'];
          $originalDateTime = $row['break_out'];
        $formattedDate = date("d-m-Y", strtotime($originalDateTime));
        $formattedTime = date("h:i A", strtotime($originalDateTime));
        $breakout = $formattedDate . ' ' . $formattedTime;

        $originalDateTime = $row['break_in'];
        if($originalDateTime=="0000-00-00 00:00:00"){
            $exit_dt="NA";
        }else{
            $formattedDate = date("d-m-Y", strtotime($originalDateTime));
            $formattedTime = date("h:i A", strtotime($originalDateTime));
            $breakin = $formattedDate . ' ' . $formattedTime;
        }





        $i++;



        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3) , ($i));
//        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3) ,$name);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3) ,$employee_id);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3) ,$date);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3) ,$breakin);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3) ,$breakout);
//        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3) ,$model);
//        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3) ,$scan_1);
//        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3) ,$scan_2);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3) ,$scan_3);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3) ,$scan_4);
//        $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 3) ,$box_code);



    }

}

//echo $_SERVER["DOCUMENT_ROOT"];



$objPHPExcel->getActiveSheet()->setCellValue('A1'," Break Attendance");
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



cellColor('A3:E3', '#181f5a');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:E3')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:E3')
    ->getFont()
    ->setSize(12)
    ->setBold(true);



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/hrms/break_attendance/emp_break.xlsx');
sleep(1);

ob_end_clean();


header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=emp_break.xlsx");
readfile($_SERVER["DOCUMENT_ROOT"].'/hrms/break_attendance/emp_break.xlsx');



@unlink($_SERVER["DOCUMENT_ROOT"].'/hrms/break_attendance/emp_break.xlsx');



?>
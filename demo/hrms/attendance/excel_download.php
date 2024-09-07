<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include("../../includes/connection.php");


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
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Employee ID');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Employee Name');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Date ');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Login Time');
//$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Login Lat');
//$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Login Lng');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'LogOut Time');
//$objPHPExcel->getActiveSheet()->setCellValue('I3', 'LogOut Lat');
//$objPHPExcel->getActiveSheet()->setCellValue('J3', 'LogOut Lng');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Duration');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Status');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Remarks');
//$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Part 2');
//$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Part 3');
//$objPHPExcel->getActiveSheet()->setCellValue('J3', 'Part 4');
//$objPHPExcel->getActiveSheet()->setCellValue('K3', 'Box No');

$i = 0;


if( $search=="") {
    $sqlquery = "SELECT * FROM attendance WHERE `date_time` BETWEEN '$from' AND '$to' ";
}else{
//    $sqlquery = "SELECT * FROM attendance, staff WHERE attendance.emp_id = staff.staff_id AND (attendance.emp_id LIKE '%$search%' OR staff.staff_name LIKE '%$search%')    AND attendance.date_time AND staff.status='1' BETWEEN '$from' AND '$to'";
    $sqlquery = "SELECT * FROM attendance AS a
                 JOIN `user` AS s ON a.emp_id = s.staff_id
                 WHERE (a.emp_id LIKE '%$search%' OR s.f_name LIKE '%$search%')
                 AND a.date_time BETWEEN '$from' AND '$to'
                ";}

$result = mysqli_query($conn, $sqlquery);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $emp_n=$row['emp_id'];
        $sqlquerys = "SELECT * FROM user WHERE staff_id='$emp_n'";
        $results = mysqli_query($conn,$sqlquerys);
        $rowss = mysqli_fetch_assoc($results);

        $sNo++;



        $name =  $rowss['f_name'];
        $employee_id =  $row['emp_id'];
        $in_lat =  $row['login_lat'];
        $in_lng =  $row['login_lng'];
        $out_lat =  $row['logout_lat'];
        $out_lng =  $row['logout_lng'];
        $date =  $row['date_time'];
        $remarks =  $row['remarks'];
//        $Login =  $row['login'];
        $Date = date("d-m-Y", strtotime($date));

        $originalDateTime = $row['login'];
        $formattedDate = date("d-m-Y", strtotime($originalDateTime));
        $formattedTime = date("h:i A", strtotime($originalDateTime));
        $Login= $formattedTime;



//        $Logout =  $row['logout'];
        $originalDateTime = $row['logout'];
        if($originalDateTime=="0000-00-00 00:00:00"){
            $Logout="NA";
        }else{
            $formattedDate = date("d-m-Y", strtotime($originalDateTime));
            $formattedTime = date("h:i A", strtotime($originalDateTime));
            $Logout= $formattedTime;
        }


        $logTime = date("H:i:s", strtotime($row['login']));
        $a = date("H:i:s", strtotime($row['logout']));

        $aa = strtotime($a);
        $bb = strtotime($logTime);

        $diff = $aa - $bb;

        $formattedDiff = gmdate("H:i:s", abs($diff));

        $Duration =  $formattedDiff;
        $Statuss =  $row['present_status'];
        if($Statuss==""){
            $Status="A";
        }else{
            $Status=$Statuss;
        }

//        $scan_3 =  $row['scan_3'];
//        $scan_4 =  $row['scan_4'];
//        $box_code =  $row['box_code'];





        $i++;



        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3) ,$employee_id);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3) ,$name);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3) ,$Date);



        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3) ,$Login);

        $originalDateTime = $row['login'];
        $formattedTime = date("H:i:s", strtotime($originalDateTime));

        $loginTime = new DateTime($formattedTime);
        $comparisonTime = new DateTime('09:45:00');

//        if ($loginTime >= $comparisonTime) {
//            cellColor('E' . ($i + 3), 'FFFA6F');
//        }


//        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3) ,$in_lat);
//        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3) ,$in_lng);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3) ,$Logout);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3) ,$out_lat);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3) ,$out_lng);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3) ,$Duration);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3) ,$Status);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3) ,$remarks);
//        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3) ,$scan_2);
//        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3) ,$scan_3);
//        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3) ,$scan_4);
//        $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 3) ,$box_code);



    }

}

//echo $_SERVER["DOCUMENT_ROOT"];



$objPHPExcel->getActiveSheet()->setCellValue('A1'," Attendance Report");
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



cellColor('A3:I3', '#181f5a');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:M3')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:M3')
    ->getFont()
    ->setSize(12)
    ->setBold(true);



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

 $_SERVER["DOCUMENT_ROOT"];

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/hrms/attendance/attendance_log.xlsx');
sleep(1);

ob_end_clean();


header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=attendance_log.xlsx");
readfile($_SERVER["DOCUMENT_ROOT"].'/hrms/attendance/attendance_log.xlsx');



@unlink($_SERVER["DOCUMENT_ROOT"].'/hrms/attendance/attendance_log.xlsx');



?>
<?php
require_once '../../includes/excel_generator/PHPExcel.php';
Include('../../includes/connection.php');

$search= $_GET['search'];
$currentYear = date('Y');
$currentmonth = date('m');
$lastYear = date('Y', strtotime('-1 year'));




$month = $_GET['month'];
$year = $_GET['year'];

if (empty($month)) {
    $month=$currentmonth;
}
if (empty($year)) {
    $year=$currentYear;
}
$daysInMonth =cal_days_in_month(CAL_GREGORIAN, $month, $year);

$fdate = '01-' . $month . '-' . $year;
$ldate = '31-' . $month . '-' . $year;

$from = date('Y-m-d', strtotime($fdate));
$to = date('Y-m-d', strtotime($ldate));
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



$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');



$objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Employee');
//$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Employee');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Gross Salary');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Net Salary');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Total Days');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Present Days');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'Absent Days');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Holidays');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Eligible Leave');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'LOP Days');
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'NET Pay');

$i = 0;


if($search == "") {
    $sql = "SELECT * FROM `user` ORDER BY user_id ASC";
}
else {
    $sql = "SELECT * FROM `user` WHERE f_name LIKE '%$search%' ORDER BY user_id ASC ";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = 0;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;

//        $branch_id = $row['branch_id'];
        $staff_id = $row['user_id'];
        $eligible_leave = $row['eligible_leave'];
        $net_salary = $row['net_salary'];


        $sqlTotal = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to'";
        $resTotal = mysqli_query($conn, $sqlTotal);
        $totalDays = mysqli_num_rows($resTotal);

        $sqlPresent = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to' AND `present_status`='P'";
        $resPresent = mysqli_query($conn, $sqlPresent);
        $totalPresent = mysqli_num_rows($resPresent);

        $sqlAbsent = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to' AND `present_status`='A'";
        $resAbsent = mysqli_query($conn, $sqlAbsent);
        $totalAbsent = mysqli_num_rows($resAbsent);

        $sqlHoliday = "SELECT * FROM `attendance` WHERE `emp_id`='$staff_id' AND `date_time` BETWEEN '$from' AND '$to' AND `present_status`='H'";
        $resHoliday = mysqli_query($conn, $sqlHoliday);
        $totalHoliday = mysqli_num_rows($resHoliday);

        if ($totalAbsent <= $eligible_leave) {
            $lop = 0;
        } else {
            $lop = $totalAbsent - $eligible_leave;
            if ($lop < 0) {
                $lop = 0;
            }
        }

        $pay_days = ($totalPresent + $totalHoliday) - $lop;

        $daysInMonth;

        $pay_perday = $net_salary / $daysInMonth;

        $total_netpay = round($pay_days * $pay_perday);



        $i++;



        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 3) , ($i));
//        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3) ,$name);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 3), $row['user_id'] . '-' . $row['f_name']);
//        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3) ,$branch_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 3) ,$row['gross_salary']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 3) ,$row['net_salary']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 3) ,$daysInMonth);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 3) ,$totalPresent);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 3) ,$totalAbsent);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 3) ,$totalHoliday);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 3) ,$row['eligible_leave']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 3) ,$lop);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 3) ,$total_netpay);



    }

}

//echo $_SERVER["DOCUMENT_ROOT"];



$objPHPExcel->getActiveSheet()->setCellValue('A1'," Payroll");
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



cellColor('A3:L3', '#181f5a');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:L3')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');



$objPHPExcel->getActiveSheet()
    ->getStyle('A3:L3')
    ->getFont()
    ->setSize(12)
    ->setBold(true);



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/hrms/payroll/payroll_list.xlsx');
sleep(1);

ob_end_clean();


header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=payroll_list.xlsx");
readfile($_SERVER["DOCUMENT_ROOT"].'/hrms/payroll/payroll_list.xlsx');



@unlink($_SERVER["DOCUMENT_ROOT"].'/hrms/payroll/payroll_list.xlsx');



?>
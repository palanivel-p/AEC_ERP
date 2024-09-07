<?php
include("../../includes/connection.php");
//include('../include/admin_access.php');
//include('../include/log_check.php');

date_default_timezone_set("Asia/Kolkata");

$yesterday = date('Y-m-d', strtotime('-1 day'));
$datef = $yesterday . ' 00:00:00';
$datet = $yesterday . ' 23:59:59';
$datelogout = $yesterday . ' 18:00:00';
$day = date('l', strtotime($yesterday));



 $sqlquery = "SELECT * FROM user WHERE `access_status`=1";
$result = mysqli_query($conn, $sqlquery);

if (mysqli_num_rows($result) > 0) {



     $sqlholiday = "SELECT * FROM holiday_list WHERE `date`='$yesterday'";
    $resultz = mysqli_query($conn, $sqlholiday);


    while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['user_id'];




//            $sqlUpdate = "UPDATE `staff` SET `daily_status` ='0' WHERE staff_id='$id'";
//        mysqli_query($conn, $sqlUpdate);


        if ($day === 'Sunday' || mysqli_num_rows($resultz) > 0) {


//               $sqlholiday = "SELECT * FROM compensation_list WHERE `date`='$yesterday' AND emp_id='$id'";
//            $resultzz = mysqli_query($conn, $sqlholiday);
//
//            if (mysqli_num_rows($resultzz) > 0) {


                   $sqlquerys = "SELECT * FROM attendance WHERE emp_id='$id' AND `login` BETWEEN '$datef' AND '$datet'";
                $results = mysqli_query($conn, $sqlquerys);

                if (mysqli_num_rows($results) == 0) {
                    $sqlInsert = "INSERT INTO `attendance`(`emp_id`,`date_time`,`login_lat`,`login_lng`,`login`,`logout`,`present_status`,`remarks`) VALUES ('$id','$yesterday','','','$datef','$datef','A','Absent')";
                    $insertResult = mysqli_query($conn, $sqlInsert);


                } else {

                    $row = mysqli_fetch_assoc($results);
                    $exit = $row['logout'];
                    $eid = $row['id'];
                    if ($exit == '0000-00-00 00:00:00') {

                        $sqlUpdatex = "UPDATE `attendance` SET `present_status` ='P',`logout`='$datelogout',`remarks`='Missed' WHERE id='$eid'";
                        mysqli_query($conn, $sqlUpdatex);
                    }

                }


//            }else{
//
//                $sqlInsertz = "INSERT INTO `attendance`(`emp_id`,`date_time`,`login_lat`,`login_lng`,`login`,`logout`,`present_status`,`remarks`) VALUES ('$id','$yesterday','','','$datef','$datef','H','Holiday')";
//                $insertResultz = mysqli_query($conn, $sqlInsertz);
//            }

        }else{

              $sqlquerys = "SELECT * FROM attendance WHERE emp_id='$id' AND `login` BETWEEN '$datef' AND '$datet'";
            $results = mysqli_query($conn, $sqlquerys);

            if (mysqli_num_rows($results) == 0) {
                    $sqlInsert = "INSERT INTO `attendance`(`emp_id`,`date_time`,`login_lat`,`login_lng`,`login`,`logout`,`present_status`,`remarks`) VALUES ('$id','$yesterday','','','$datef','$datef','A','Absent')";
                $insertResult = mysqli_query($conn, $sqlInsert);


            } else {

                $row = mysqli_fetch_assoc($results);
                $exit = $row['logout'];
                $eid = $row['id'];
                if ($exit == '0000-00-00 00:00:00') {

                       $sqlUpdatex = "UPDATE `attendance` SET `present_status` ='P',`logout`='$datelogout',`remarks`='Missed' WHERE id='$eid'";
                    mysqli_query($conn, $sqlUpdatex);
                }

            }



        }
    }
} else {
    $json_array['status'] = "failure";
    $json_array['msg'] = "Emlployee Missing";
     json_encode($json_array);
}

?>
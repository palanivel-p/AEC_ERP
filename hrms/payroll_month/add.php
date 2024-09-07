<?php

Include("../../includes/connection.php");
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['no_days'])&& isset($_POST['payroll_month'])) {


    $no_days = clean($_POST['no_days']);
    $payroll_month = clean($_POST['payroll_month']);


    $date = date('Y-m-d');

    $added_by = $_COOKIE['user_id'];

    $api_key = $_COOKIE['panel_api_key'];

    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {
//
//        $sqlValidateCheque = "SELECT * FROM `payroll_month` WHERE payroll_month='$payroll_month'";
//        $resValidateCheque = mysqli_query($conn, $sqlValidateCheque);
//        if (mysqli_num_rows($resValidateCheque) > 0) {

            $sqlInsert = "INSERT INTO `payroll_month`(`payroll_id`, `payroll_month`,`payroll_days`) 
                                            VALUES ('','$payroll_month','$no_days')";

            mysqli_query($conn, $sqlInsert);

            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $payroll_id = "PM" . ($ID);

            $sqlUpdate = "UPDATE payroll_month SET payroll_id = '$payroll_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);


            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Added successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;
//        }
//
//        else {
//            //Parameters missing
//
//            $json_array['status'] = "failure";
//            $json_array['msg'] = "Cheque No Already Exist !!!";
//            $json_response = json_encode($json_array);
//            echo $json_response;
//        }
    }

    else {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Login !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>

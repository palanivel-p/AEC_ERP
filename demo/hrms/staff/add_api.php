<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['staff_name'])&&isset($_POST['mobile'])&& isset($_POST['email'])) {
    Include("../../includes/connection.php");

    $staff_id = clean($_POST['staff_id']);
    $staff_id = strtoupper($staff_id);
    $staff_name = clean($_POST['staff_name']);
    $branch_name = clean($_POST['branch_name']);
    $role = $_POST['role'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $access_status = $_POST['active_status'];

    $date = date('Y-m-d');

 $leave = $_POST['leave'];
    $gross = $_POST['gross'];
    $deduction = $_POST['deduction'];
$net=$gross-$deduction;
//    $added_by = $_COOKIE['user_id'];

    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `staff`(`staff_id`, `staff_name`,`branch_id`,`role`,`mobile`,`email`,`password`,`access_status`,gross_salary,net_salary,deduction,eligible_leave)
                                            VALUES ('$staff_id','$staff_name','$branch_name','$role','$mobile','$email','$password','$access_status','$gross','$net','$deduction','$leave')";

        mysqli_query($conn, $sqlInsert);


        //log
//        $info = urlencode("Added Game - " . $game_id);
//        file_get_contents($website . "portal/includes/log.php?api_key=$api_key&info=$info");

        //inserted successfully
        $json_array['status'] = "success";
        $json_array['msg'] = "Added successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
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

<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['purchase_id']))
{
    Include("../includes/connection.php");

    $purchase_id = $_POST['purchase_id'];
//    $doner_id = $_POST['doner_id'];


    $date = date('Y-m-d h:i:s');

    $api_key = $_COOKIE['panel_api_key'];


    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
//    $role = $_COOKIE['role'];
//    if($role == 'Super Admin'){
//        $sqlValidateCookie = "SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
//
//    }
//    elseif ($role == 'Admin'){
//        $sqlValidateCookie = "SELECT * FROM `branch_profile` WHERE panel_api_key='$api_key'";
//
//    }
//    else {
//        $sqlValidateCookie = "SELECT * FROM `staff_profile` WHERE panel_api_key='$api_key'";
//
//    }
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `purchase_v1` WHERE purchase_id='$purchase_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 )  {


            $sqlUpdate = "UPDATE `purchase_v1` SET `approve`='1',`approve_date`='$date' WHERE `purchase_id`='$purchase_id'";
            mysqli_query($conn, $sqlUpdate);


            $json_array['status'] = "success";
            $json_array['msg'] = "Approved successfully";
            $json_response = json_encode($json_array);
            echo $json_response;
        }

        else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Purchase ID Is Not Valid";
            $json_response = json_encode($json_array);
            echo $json_response;
        }
    }
    else
    {
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

?>

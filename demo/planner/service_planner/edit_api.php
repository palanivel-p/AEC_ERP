<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['service_id']))
{
    Include("../../includes/connection.php");

    $service_id = $_POST['service_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $plan_date = clean($_POST['visit_date']);
    $customer_name = $_POST['customer_name'];
    $meet = $_POST['meet'];
    $mobile = $_POST['mobile'];
    $assigned = $_POST['assigned'];
    $communication = clean($_POST['communication']);
    $notes = clean($_POST['notes']);

    $date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];


    $added_by = $_COOKIE['user_id'];
//    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `service` WHERE service_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($service_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `service` SET `service_id`='$service_id',`next_follow`='$plan_date',`customer_name`='$customer_name',`meet_whom`='$meet',`mobile`='$mobile',`assigned_to`='$assigned',`communication`='$communication',`notes` = '$notes' WHERE `service_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);



            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "service ID Is Not Valid";
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
function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
?>

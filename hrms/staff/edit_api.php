<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['staff_id']))
{
    Include("../../includes/connection.php");

    $staff_id = $_POST['staff_id'];
    $staff_id = strtoupper($staff_id);
    $old_pa_id = $_POST['old_pa_id'];
    $staff_name = $_POST['staff_name'];
    $branch_name = $_POST['branch_name'];
    $role = $_POST['role'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $access_status = $_POST['active_status'];
    $leave = $_POST['leave'];
    $gross = $_POST['gross'];
    $deduction = $_POST['deduction'];
    $net=$gross-$deduction;
    $date = date('Y-m-d');
    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `staff` WHERE id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($staff_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `staff` SET `staff_id`='$staff_id',`staff_name`='$staff_name',`branch_id`='$branch_name',`role`='$role',`mobile`='$mobile',`email`='$email',`password`='$password',`eligible_leave`='$leave',`gross_salary`='$gross',`deduction`='$deduction',`net_salary`='$net',`access_status`='$access_status' WHERE `id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);


            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Staff ID Is Not Valid";
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

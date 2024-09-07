<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['product_id']))
{
    Include("../includes/connection.php");

    $product_id = $_POST['product_id'];
    $p_cost = $_POST['p_cost'];
    $p_price = $_POST['p_price'];


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

        $sqlValidate = "SELECT * FROM `product` WHERE product_id='$product_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 )  {


            $sqlUpdate = "UPDATE `product` SET `request`=1,`edit_request`=0,`request_date`='$date',`product_price`='$p_price',`product_cost`='$p_cost' WHERE `product_id`='$product_id'";
            mysqli_query($conn, $sqlUpdate);


            $json_array['status'] = "success";
            $json_array['msg'] = "Approved successfully";
            $json_response = json_encode($json_array);
            echo $json_response;
        }

        else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Product ID Is Not Valid";
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

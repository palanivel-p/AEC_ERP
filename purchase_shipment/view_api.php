<?php
if(isset($_POST['shipping_id']))
{
    Include("../includes/connection.php");


    $shipping_id = $_POST['shipping_id'];
    $api_key = $_COOKIE['panel_api_key'];

    $added_by = $_COOKIE['user_id'];
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }

    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0)
    {
        $sqlData="SELECT * FROM `purchase_shipment` WHERE shipping_id='$shipping_id'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);

            $json_array['status'] = 'success';
            $json_array['shipping_id'] = $row['shipping_id'];
            $json_array['destination'] = $row['destination'];
            $json_array['dispatched_through'] = $row['dispatched_through'];
            $json_array['delivery_date'] = $row['delivery_date'];
            $json_array['ps_date'] = $row['ps_date'];
            $json_array['shipping_amount'] = $row['shipping_amount'];
            $json_array['terms_delivery'] = $row['terms_delivery'];
            $json_array['vehicle_no'] = $row['vehicle_no'];
            $json_array['other_charges'] = $row['other_charges'];
            $json_array['supplier_name'] = $row['supplier_name'];

            $json_array['date'] = $row['date'];

            $json_response = json_encode($json_array);
            echo $json_response;
        }

    }
    else
    {
        //staff id already exist

        $json_array['status'] = "wrong";
        $json_array['msg'] = "Login Invalid";
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

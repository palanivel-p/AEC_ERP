<?php
if(isset($_POST['supplier_id']))
{
    Include("../../includes/connection.php");


    $supplier_id = $_POST['supplier_id'];
    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";

    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0)
    {
        $sqlData="SELECT * FROM `supplier` WHERE supplier_id='$supplier_id'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);

            $json_array['status'] = 'success';
            $json_array['supplier_id'] = $row['supplier_id'];
            $json_array['supplier_name'] = $row['supplier_name'];
            $json_array['supplier_email'] = $row['supplier_email'];
            $json_array['supplier_phone'] = $row['supplier_phone'];
            $json_array['supplier_phone1'] = $row['supplier_phone1'];
            $json_array['gstin'] = $row['gstin'];
            $json_array['address1'] = $row['address1'];
            $json_array['address2'] = $row['address2'];
            $json_array['supply_palce'] = $row['supply_palce'];

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

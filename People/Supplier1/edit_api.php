<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['supplier_id']))
{
    Include("../../includes/connection.php");

    $supplier_id = $_POST['supplier_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_phone = $_POST['supplier_phone'];
    $supplier_phone1 = $_POST['supplier_phone1'];
    $gstin = $_POST['gstin'];
    $gst=  strtoupper($gstin) ;
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $supply_place = $_POST['supply_place'];

    $date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];


    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `supplier` WHERE supplier_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($supplier_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `supplier` SET `supplier_id`='$supplier_name',`supplier_email`='$supplier_email',`supplier_phone`='$supplier_phone',`gstin`='$gst',`address1`='$address1',`address2`='$address2',`supplier_phone1`='$supplier_phone1',`supply_place`='$supply_place' WHERE `supplier_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);



            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "supplier ID Is Not Valid";
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

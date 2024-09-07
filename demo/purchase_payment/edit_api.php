<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['repayment_id']))
{
    Include("../includes/connection.php");

    $repayment_id = $_POST['repayment_id'];
    $repayment_date = $_POST['repayment_date'];
    $Purch_id = $_POST['Purch_id'];
    $g_total = $_POST['g_total'];
    $due_amount = $_POST['due_amount'];
    $paid_amount = $_POST['paid_amount'];
    $pay_made = $_POST['pay_made'];
    $repayment_mode = $_POST['repayment_mode'];
    $bank_name = $_POST['bank_name'];
    $ref_no_c = $_POST['ref_no_c'];
    $reference_no = $_POST['ref_no'];
    $notes = $_POST['notes'];
    $purchase_id = $_POST['Purch_id'];

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

        $sqlValidate = "SELECT * FROM `purchase_payment` WHERE repayment_id='$repayment_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0)  {

            $sqlUpdate = "UPDATE `purchase_payment` SET `purchase_id`='$purchase_id',`repayment_date`='$repayment_date',`bank_name` = '$bank_name',`pay_made`='$pay_made',`repayment_mode`='$repayment_mode',`notes`='$notes',`ref_no_c`='$ref_no_c',`ref_no`='$ref_no' WHERE `repayment_id`='$repayment_id'";
            mysqli_query($conn, $sqlUpdate);

            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Payment ID Is Not Valid";
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

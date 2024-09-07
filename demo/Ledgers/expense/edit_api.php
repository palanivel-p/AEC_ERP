<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['expense_id']))
{
    Include("../../includes/connection.php");

    $expense_id = $_POST['expense_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $expense_type = $_POST['category_type'];
    $expense_date = $_POST['expense_date'];
    $amount = $_POST['amount'];
    $credit_days = $_POST['credit_days'];
    $supplier = $_POST['supplier'];
    $payment_mode = $_POST['repayment_mode'];
    $details = $_POST['details'];
    $ref_no_c = $_POST['ref_no_c'];
    $reference_no = $_POST['ref_no'];
    $payment_status = $_POST['payment_status'];
    $due_date = $_POST['due_date'];

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

        $sqlValidate = "SELECT * FROM `expense` WHERE expense_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($expense_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `expense` SET `expense_id`='$expense_id',`expense_type`='$expense_type',`expense_date`='$expense_date',`amount`='$amount',`payment_mode`='$payment_mode',`details`='$details',`credit_days`='$credit_days',`supplier` = '$supplier',`reference_no`='$reference_no',`due_date`='$due_date',`payment_status`='$payment_status',`ref_no_c`='$ref_no_c' WHERE `expense_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);



            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Expense ID Is Not Valid";
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

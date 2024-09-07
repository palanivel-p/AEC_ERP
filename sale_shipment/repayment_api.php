<?php

date_default_timezone_set("Asia/Kolkata");
// if(isset($_POST['borrower']) &&isset($_POST['loan_date'])) {
Include("../includes/connection.php");

$purchase_id = clean($_POST['pur_id']);
$shipping_id = clean($_POST['repayment_id']);
$repayment_date = clean($_POST['repayment_date']);
$pay_made = clean($_POST['pay_made']);
$repayment_mode = clean($_POST['repayment_mode']);
$ref_no = clean($_POST['ref_no']);
$ref_no_c = clean($_POST['ref_no_c']);
$notes = clean($_POST['notes']);
$bank_name = clean($_POST['bank_name']);


$date = date('Y-m-d');

//    $added_by = $_COOKIE['user_id'];

$api_key = $_COOKIE['panel_api_key'];

$added_by = $_COOKIE['user_id'];
//    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
if ($_COOKIE['role'] == 'Super Admin'){
    $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
}
else {
    $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
}
$resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
if (mysqli_num_rows($resValidateCookie) > 0) {

    $sqlInsert = "INSERT INTO `sale_dc`(`sale_id`,`repayment_id`,`repayment_date`,`pay_made`,`repayment_mode`,`ref_no`,`ref_no_c`,`notes`,`bank_name`) 
                                            VALUES ('$purchase_id','$shipping_id','$repayment_date','$pay_made','$repayment_mode','$ref_no','$ref_no_c','$notes','$bank_name')";

    mysqli_query($conn, $sqlInsert);

    $ID=mysqli_insert_id($conn);

    if(strlen($ID)==1)
    {
        $ID='00'.$ID;

    }elseif(strlen($ID)==2)
    {
        $ID='0'.$ID;
    }

    $dc_id="SDC".($ID);

    $sqlUpdate = "UPDATE sale_dc SET dc_id = '$dc_id' WHERE id ='$ID'";
    mysqli_query($conn, $sqlUpdate);

    $sqlpurchase = "SELECT * FROM `sale` WHERE `sale_id`='$purchase_id'";
    $respurchase = mysqli_query($conn, $sqlpurchase);
    $rowpurchase = mysqli_fetch_assoc($respurchase);
    $customer_id =  $rowpurchase['supplier'];
    $sqlSupplier = "SELECT * FROM `supplier` WHERE `customer_id`='$customer_id'";
    $resSupplier = mysqli_query($conn, $sqlSupplier);
    $rowSupplier = mysqli_fetch_assoc($resSupplier);
    $customer_name =  $rowSupplier['customer_name'];

    if($ref_no_c != ''){
        $sqlUpdateCheque = "UPDATE cheque_list SET cheque_status = 1,cheque_used = '$purchase_id',cheque_type='purchase',due_date='$due_date',purchase_date='$purchase_date',cs_name='$supplier_name' WHERE cheque_no ='$ref_no_c'";
        mysqli_query($conn, $sqlUpdateCheque);
    }

    $sqlInsertBank = "INSERT INTO `bank_details`(`b_id`,`ref_id`, `bank_name`,`payment_date`,`pay_from`,`customer_name`,`pay_mode`,`amount`,`ref_no`,`type`) 
                                            VALUES ('', '$purchase_id','$bank_name','$repayment_date','sale_dc_payment','$customer_name','$repayment_mode','$pay_made','$ref_no','Credit')";

    mysqli_query($conn, $sqlInsertBank);

    $ID = mysqli_insert_id($conn);

    if (strlen($ID) == 1) {
        $ID = '00' . $ID;

    } elseif (strlen($ID) == 2) {
        $ID = '0' . $ID;
    }

    $b_id = "B" . ($ID);

    $sqlUpdateBank = "UPDATE bank_details SET b_id = '$b_id' WHERE id ='$ID'";
    mysqli_query($conn, $sqlUpdateBank);

    //log
//        $info = urlencode("Added Game - " . $game_id);
//        file_get_contents($website . "portal/includes/log.php?api_key=$api_key&info=$info");

    $role=$_COOKIE['role'];
    $staff_id=$_COOKIE['user_id'];
    $staff_name=$_COOKIE['user_name'];
    $info = urlencode("Sale Shipment Payment Added");
    $role = urlencode($role); // Assuming $id is a variable with the emp_id value
    $staff_id = urlencode($staff_id); // Assuming $id is a variable with the emp_id value
    $staff_name = urlencode($staff_name); // Assuming $id is a variable with the emp_id value
    $url = "https://erp.aecindia.net/includes/log_api.php?message=$info&role=$role&staff_id=$staff_id&staff_name=$staff_name";
    file_get_contents($url);

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
// }
// else
// {
//     //Parameters missing

//     $json_array['status'] = "failure";
//     $json_array['msg'] = "Please try after sometime !!!";
//     $json_response = json_encode($json_array);
//     echo $json_response;
// }



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>

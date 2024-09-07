<?php

date_default_timezone_set("Asia/Kolkata");
// if(isset($_POST['borrower']) &&isset($_POST['loan_date'])) {
Include("../includes/connection.php");

$sale_id = clean($_POST['saleid']);
$repayment_date = clean($_POST['repayment_date']);
$pay_made = clean($_POST['pay_made']);
$repayment_mode = clean($_POST['repayment_mode']);
$ref_no = clean($_POST['ref_no']);
$ref_no_c = clean($_POST['ref_no_c']);
$notes = clean($_POST['notes']);
$tds = $_POST['tds'];
$bank_name = clean($_POST['bank_name']);

$sqlSupplier = "SELECT * FROM `sale` WHERE `sale_id`='$sale_id'";
$resSupplier = mysqli_query($conn, $sqlSupplier);
$rowSupplier = mysqli_fetch_assoc($resSupplier);
$customer_id =  $rowSupplier['customer'];

$sqlSN = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
$resSN  = mysqli_query($conn, $sqlSN );
$rowSN  = mysqli_fetch_assoc($resSN );
$customer_name =  $rowSN ['customer_name'];
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

   echo $sqlInsert = "INSERT INTO `sale_payment`(`sale_id`,`repayment_date`,`pay_made`,`repayment_mode`,`ref_no`,`ref_no_c`,`notes`,'tds') 
                                            VALUES ('$sale_id','$repayment_date','$pay_made','$repayment_mode','$ref_no','$ref_no_c','$notes','$tds')";

    mysqli_query($conn, $sqlInsert);

    $ID=mysqli_insert_id($conn);

    if(strlen($ID)==1)
    {
        $ID='00'.$ID;

    }elseif(strlen($ID)==2)
    {
        $ID='0'.$ID;
    }

    $repayment_id="SP".($ID);

    $sqlUpdate = "UPDATE sale_payment SET repayment_id = '$repayment_id' WHERE id ='$ID'";
    mysqli_query($conn, $sqlUpdate);

    $sqlInsertBank = "INSERT INTO `bank_details`(`b_id`,`ref_id`, `bank_name`,`payment_date`,`pay_from`,`customer_name`,`pay_mode`,`amount`,`ref_no`,`type`) 
                                            VALUES ('', '$repayment_id','$bank_name','$repayment_date','Sale_payment','$customer_name','$repayment_mode','$pay_made','$ref_no','Credit')";

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


    $sqlpurchase = "SELECT * FROM `sale` WHERE `sale_id`='$sale_id'";
    $respurchase = mysqli_query($conn, $sqlpurchase);
    $rowpurchase = mysqli_fetch_assoc($respurchase);
    $due_date =  $rowpurchase['due_date'];
    $sale_date =  $rowpurchase['sale_date'];
    $customer_id =  $rowpurchase['customer'];
    $sqlSupplier = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
    $resSupplier = mysqli_query($conn, $sqlSupplier);
    $rowSupplier = mysqli_fetch_assoc($resSupplier);
    $customer_name =  $rowSupplier['customer_name'];

    if($ref_no_c != ''){
        $sqlUpdateCheque = "UPDATE cheque_list SET cheque_status = 1,cheque_used = '$purchase_id',cheque_type='sale',due_date='$due_date',purchase_date='$purchase_date',cs_name='$supplier_name' WHERE cheque_no ='$ref_no_c'";
        mysqli_query($conn, $sqlUpdateCheque);
    }
    //log
//        $info = urlencode("Added Game - " . $game_id);
//        file_get_contents($website . "portal/includes/log.php?api_key=$api_key&info=$info");
    $role=$_COOKIE['role'];
    $staff_id=$_COOKIE['user_id'];
    $staff_name=$_COOKIE['user_name'];
    $info = urlencode("Sale Repayment Added");
    $role = urlencode($role); // Assuming $id is a variable with the emp_id value
    $staff_id = urlencode($staff_id); // Assuming $id is a variable with the emp_id value
    $staff_name = urlencode($staff_name); // Assuming $id is a variable with the emp_id value
    $url = "https://erp.aecindia.net/includes/log_api.php?message=$info&role=$role&staff_id=$staff_id&staff_name=$staff_name";
    file_get_contents($url);

    //inserted successfully

    $json_array['status'] = "success";
    $json_array['msg'] = "Payment successfully !!!";
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

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

    $sqlInsert = "INSERT INTO `purchase_dc`(`purchase_id`,`repayment_id`,`repayment_date`,`pay_made`,`repayment_mode`,`ref_no`,`ref_no_c`,`notes`,`bank_name`) 
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

    $dc_id="PDC".($ID);

    $sqlUpdate = "UPDATE purchase_dc SET dc_id = '$dc_id' WHERE id ='$ID'";
    mysqli_query($conn, $sqlUpdate);

    $sqlpurchase = "SELECT * FROM `purchase` WHERE `purchase_id`='$purchase_id'";
    $respurchase = mysqli_query($conn, $sqlpurchase);
    $rowpurchase = mysqli_fetch_assoc($respurchase);
    $due_date =  $rowpurchase['due_date'];
    $purchase_date =  $rowpurchase['purchase_date'];
    $supplier_id =  $rowpurchase['supplier'];
    $sqlSupplier = "SELECT * FROM `supplier` WHERE `supplier_id`='$supplier_id'";
    $resSupplier = mysqli_query($conn, $sqlSupplier);
    $rowSupplier = mysqli_fetch_assoc($resSupplier);
    $supplier_name =  $rowSupplier['supplier_name'];

    if($ref_no_c != ''){
        $sqlUpdateCheque = "UPDATE cheque_list SET cheque_status = 1,cheque_used = '$purchase_id',cheque_type='purchase',due_date='$due_date',purchase_date='$purchase_date',cs_name='$supplier_name' WHERE cheque_no ='$ref_no_c'";
        mysqli_query($conn, $sqlUpdateCheque);
    }
    //log
//        $info = urlencode("Added Game - " . $game_id);
//        file_get_contents($website . "portal/includes/log.php?api_key=$api_key&info=$info");

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

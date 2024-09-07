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

    $sqlInsert = "INSERT INTO `sale_payment`(`sale_id`,`repayment_date`,`pay_made`,`repayment_mode`,`ref_no`,`ref_no_c`,`notes`) 
                                            VALUES ('$sale_id','$repayment_date','$pay_made','$repayment_mode','$ref_no','$ref_no_c','$notes')";

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

    $sqlGrand = "SELECT * FROM `sale` WHERE `sale_id`='$sale_id'";
    $resGrand = mysqli_query($conn, $sqlGrand);
    $rowGrand = mysqli_fetch_assoc($resGrand);
    $Grand =  $rowGrand['grand_total'];

    $sqlamount="SELECT SUM(pay_made) AS pay_made  FROM sale_payment WHERE sale_id='$sale_id'";
    $resamount=mysqli_query($conn,$sqlamount);
    if(mysqli_num_rows($resamount)>0){
        $arrayamount=mysqli_fetch_array($resamount);
        $totalAmount=$arrayamount['pay_made'];
    }

    if($totalAmount == ''){
        $payment_status = 'UnPaid';
    }
    elseif($totalAmount == $Grand){
        $payment_status = 'Paid';
    }
    elseif ($totalAmount < $Grand){
        $payment_status = 'Partially Paid';
    }

    $sqlUpdates = "UPDATE sale SET total_pay = '$totalAmount',py_status = '$payment_status' WHERE sale_id ='$sale_id'";
    mysqli_query($conn, $sqlUpdates);
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

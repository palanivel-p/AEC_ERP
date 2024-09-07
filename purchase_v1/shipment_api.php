<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['date'])) {
    Include("../includes/connection.php");

    $date = clean($_POST['date']);
    $payment_terms = clean($_POST['payment_terms']);
    $d_note = clean($_POST['d_note']);
    $d_date = clean($_POST['d_date']);
    $d_through = clean($_POST['d_through']);
    $destination = clean($_POST['destination']);
    $other_charges = clean($_POST['other_charges']);
    $vehicle_no = clean($_POST['vehicle_no']);
    $shipping_amount = clean($_POST['shipping_amount']);

    $purchase_id = clean($_POST['p_id']);


    $date = date('Y-m-d');

//    $added_by = $_COOKIE['user_id'];

    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {

        $sqlInsert = "INSERT INTO `purchase_shipment`(`shipping_id`,`dispatch_doc`,`purchase_id`,`destination`,`dispatched_through`,`delivery_date`,`shipping_amount`,`terms_delivery`,`vehicle_no`,`other_charges`,`date`) 
                                            VALUES ('','','$purchase_id','$destination','$d_through','$d_date','$shipping_amount','$payment_terms','$vehicle_no','$other_charges','$date')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $shipping_id="PSH".($ID);

        $sqlUpdate = "UPDATE purchase_shipment SET shipping_id = '$shipping_id',dispatch_doc = '$shipping_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);
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
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>

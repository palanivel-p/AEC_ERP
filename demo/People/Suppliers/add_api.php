<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['supplier_name'])&&isset($_POST['supplier_email'])) {
    Include("../../includes/connection.php");

    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_phone = $_POST['supplier_phone'];
    $supplier_phone1 = $_POST['supplier_phone1'];
    $gstin = $_POST['gstin'];
    $gst = strtoupper($gstin);
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $bank_name = clean($_POST['bank_name']);
    $account_name = clean($_POST['acc_name']);
    $account_no = clean($_POST['acc_no']);
    $ifsc_code = clean($_POST['ifsc']);
    $branch_name = clean($_POST['branch_name']);
    $access_status = $_POST['active_status'];
    $supply_place = $_POST['supply_place'];
    $country = $_POST['country'];
    $other_state = $_POST['other_state'];
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


        $sqlInsert = "INSERT INTO `supplier`(`supplier_id`, `supplier_name`,`supplier_email`,`supplier_phone`,`supplier_phone1`,`address1`,`address2`,`gstin`,`same_address`,`bank_name`,`account_name`,`account_no`,`ifsc_code`,`branch_name`,`supply_place`,`other_state`,`country`) 
                                            VALUES ('','$supplier_name','$supplier_email','$supplier_phone','$supplier_phone1','$address1','$address2','$gstin','$access_status','$bank_name','$account_name','$account_no','$ifsc_code','$branch_name','$supply_place','$other_state','$country')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $supplier_id="S".($ID);

        $sqlUpdate = "UPDATE supplier SET supplier_id = '$supplier_id' WHERE id ='$ID'";
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

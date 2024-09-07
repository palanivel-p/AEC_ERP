<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['supplier_name'])&&isset($_POST['supplier_email'])) {
    Include("../../includes/connection.php");

    $supplier_name = $_POST['supplier_name'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_phone = $_POST['supplier_phone'];
    $supplier_phone1= $_POST['supplier_phone1'];
    $gstin = $_POST['gstin'];
    $gst=  strtoupper($gstin) ;
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $supply_place = $_POST['supply_place'];

    // $date = date('Y-m-d');
    // $job_descriptions =  str_replace("'", "", $job_description);
//    $added_by = $_COOKIE['user_id'];
    $api_key = $_COOKIE['panel_api_key'];



    $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


    echo    $sqlInsert = "INSERT INTO `supplier`(`supplier_id`,`supplier_name`,`supplier_email`,`supplier_phone`,`address1`,`address2`,`supplier_phone1`,`supply_place`,`gstin`) 
                                            VALUES ('','$supplier_name','$supplier_email','$supplier_phone','$address1','$address2','$supplier_phone1','$supply_place','$gst')";

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

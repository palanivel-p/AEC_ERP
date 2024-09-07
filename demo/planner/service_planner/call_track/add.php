<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['visit_date'])) {
    Include("../../../includes/connection.php");

    $plan_date = clean($_POST['visit_date']);
    $customer_name = $_POST['customer_name'];
    $meet = $_POST['meet'];
    $mobile = $_POST['mobile'];
    $assigned = $_POST['assigned'];
    $communication = clean($_POST['communication']);
    $notes = clean($_POST['notes']);
    $next_date = clean($_POST['next_date']);



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

        $sqlInsert = "INSERT INTO `service`(`service_id`,`visit_date`,`next_follow`,`customer_name`,`communication`,`assigned_to`,`notes`,`mobile`,`meet_whom`,`call`) 
                                            VALUES ('','$plan_date','$next_date','$customer_name','$communication','$assigned','$notes','$mobile','$meet','1')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $service_id="SC".($ID);

        $sqlUpdate = "UPDATE service SET service_id = '$service_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);


        $sqlInsert = "INSERT INTO `call_service`(`call_service_id`,`customer_name`,`customer_id`,`call_date`,`notes`,`next_date`) 
                                            VALUES ('','$customer_name','$customer_name','$plan_date','$notes','$next_date')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $call_track_id="ST".($ID);

        $sqlUpdate = "UPDATE call_service SET call_service_id = '$call_track_id' WHERE id ='$ID'";
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

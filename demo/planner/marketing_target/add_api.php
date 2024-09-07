<?php
$added_by = $_COOKIE['user_id'];

date_default_timezone_set("Asia/Kolkata");
$current_date = date('Y-m-d');
if(isset($_POST['month'])) {
    Include("../../includes/connection.php");
    //furnace&laddle
    $month  = clean($_POST['month']);
    $commitment_value = clean($_POST['commitment_value']);
    $no_visit = clean($_POST['no_visit']);

    $personalLoan = $_POST['personalLoan'];
    $personalLoanAr = explode(",",$personalLoan);
    $countPersonalLoans = count($personalLoanAr);


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

        //Furnace lining

        $sqlInsert = "INSERT INTO `target`(`target_id`, `month`,`commitment_value`,`no_visit`)
                                           VALUES ('','$month','$commitment_value','$no_visit')";
        mysqli_query($conn, $sqlInsert);
        $ID=mysqli_insert_id($conn);
        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }
        $target_id="T".($ID);
        $sqlUpdate = "UPDATE target SET target_id = '$target_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);


        for ($pl = 0; $pl < $countPersonalLoans; $pl++) {
            $plValues = $personalLoanAr[$pl];
            $plValues = substr($plValues, 0, -1);
            $plValuesAr = explode("%", $plValues);


            $sqlInsertPLoan = "INSERT INTO `target_detail`(`target_id`, `product_id`, `qty`)
                                           VALUES ('$target_id','$plValuesAr[0]','$plValuesAr[1]')";
            mysqli_query($conn, $sqlInsertPLoan);
            $IDs=mysqli_insert_id($conn);
            if(strlen($IDs)==1)
            {
                $IDs='00'.$IDs;

            }elseif(strlen($IDs)==2)
            {
                $IDs='0'.$IDs;
            }
            $target_detail_id="TD".($IDs);
            $sqlUpdates = "UPDATE target_detail SET target_detail_id = '$target_detail_id' WHERE id ='$IDs'";
            mysqli_query($conn, $sqlUpdates);
        }
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

<?php
$added_by = $_COOKIE['user_id'];

date_default_timezone_set("Asia/Kolkata");
$current_date = date('Y-m-d');
if(isset($_POST['customer_name'])) {
    Include("../includes/connection.php");
    //furnace&laddle
    $customer_name = clean($_POST['customer_name']);
    $service_id = clean($_POST['service_id']);
    $material_type = clean($_POST['material_type']);
    $location = clean($_POST['location']);
    $monthly_production = clean($_POST['monthly_production']);
    $shift = clean($_POST['shift']);
    $charges = clean($_POST['charges']);


    $personalLoan = $_POST['personalLoan'];
    $personalLoanAr = explode(",",$personalLoan);
    $countPersonalLoans = count($personalLoanAr);

    $homeLoan = $_POST['homeLoan'];
    $homeLoanAr = explode(",",$homeLoan);
    $countHomeLoans = count($homeLoanAr);

    $cardLoan = $_POST['cardLoan'];
    $cardLoans = explode(",",$cardLoan);
    $countCardLoans = count($cardLoans);

    $goldLoan = clean($_POST['goldLoan']);
    $goldLoans = explode(",",$goldLoan);
    $countGoldLoans = count($goldLoans);

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

        $sqlInsert = "INSERT INTO `service_profile`(`service_profile_id`, `customer_name`,`material_type`,`location`,`monthly_production`,`shift`,`charges`,`added_date`,`added_by`)
                                           VALUES ('','$customer_name','$material_type','$location','$monthly_production','$shift','$charges','$current_date','$added_by')";
        mysqli_query($conn, $sqlInsert);
        $ID=mysqli_insert_id($conn);
        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }
        $service_profile_id="MP".($ID);
        $sqlUpdate = "UPDATE service_profile SET service_profile_id = '$service_profile_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);


        for ($pl = 0; $pl < $countPersonalLoans; $pl++) {
            $plValues = $personalLoanAr[$pl];
            $plValues = substr($plValues, 0, -1);
            $plValuesAr = explode("%", $plValues);


            $sqlInsertPLoan = "INSERT INTO `service_details`(`service_profile_id`,`type`, `capacity`, `no_laddle`,`compititer`,`tapping_temperature`,`power`,`sg`,`grey`,`fork_height`,`linning_material`,`linning_lite`,`patching`,`base_metal`,`tapping`,`furnace_dia`,`former_dia`,`coilcoat_dia`,`wall_thickness`,`bottom_height`,`furnace_height`,`former_height`,`gld_height`)
                                           VALUES ('$service_profile_id','furnace','$plValuesAr[0]','$plValuesAr[1]','$plValuesAr[2]','$plValuesAr[3]','$plValuesAr[4]','$plValuesAr[5]','$plValuesAr[6]','$plValuesAr[7]','$plValuesAr[8]','$plValuesAr[9]','$plValuesAr[10]','$plValuesAr[11]','$plValuesAr[12]','$plValuesAr[13]','$plValuesAr[14]','$plValuesAr[15]','$plValuesAr[16]','$plValuesAr[17]','$plValuesAr[18]','$plValuesAr[19]','$plValuesAr[20]')";
            mysqli_query($conn, $sqlInsertPLoan);
        }


        for ($hl = 0; $hl < $countHomeLoans; $hl++) {
            $hlValues = $homeLoanAr[$hl];
            $hlValues = substr($hlValues, 0, -1);
            $hlValuesAr = explode("%", $hlValues);

            $sqlInsertHLoan = "INSERT INTO `service_laddle`(`service_profile_id`,`pre_heating`, `laddle_type`, `laddle_shape`,`capacity`,`qty`,`current_linning`,`patching_material`,`coating_material`,`linninglite`,`competitor`,`sg`,`grey`,`laddle_dia`,`laddle_former_dia`,`laddle_thickness`,`laddle_height`,`laddle_bottom_height`,`laddle_former_height`) 
                                           VALUES ('$service_profile_id','$plValuesAr[0]','$plValuesAr[1]','$plValuesAr[2]','$plValuesAr[3]','$plValuesAr[4]','$plValuesAr[5]','$plValuesAr[6]','$plValuesAr[7]','$plValuesAr[8]','$plValuesAr[9]','$plValuesAr[10]','$plValuesAr[11]','$plValuesAr[12]','$plValuesAr[13]','$plValuesAr[14]','$plValuesAr[15]','$plValuesAr[16]','$plValuesAr[17]')";
            mysqli_query($conn, $sqlInsertHLoan);
        }


        for($cl=0;$cl<$countCardLoans;$cl++){
            $clValues = $cardLoans[$cl];
            $clValues = substr($clValues, 0, -1);
            $clValuesAr = explode("%",$clValues);



            $sqlInsertCLoan = "INSERT INTO `service_contact`(`service_profile_id`, `name`, `position`, `mobile`, `email`) 
                                           VALUES ('$service_profile_id','$clValuesAr[0]','$clValuesAr[1]','$clValuesAr[2]','$clValuesAr[3]')";
            mysqli_query($conn, $sqlInsertCLoan);

        }

        for($gl=0;$gl<$countGoldLoans;$gl++) {
            $glValues = $goldLoans[$gl];
            $glValues = substr($glValues, 0, -1);
            $glValuesAr = explode("%", $glValues);

            $sqlInsertGLoan = "INSERT INTO `service_requirement`(`service_profile_id`, `product_name`, `category`, `supplier`, `qty`) 
                                           VALUES ('$service_profile_id','$glValuesAr[0]','$glValuesAr[1]','$glValuesAr[2]','$glValuesAr[3]')";

            mysqli_query($conn, $sqlInsertGLoan);

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

<?php
date_default_timezone_set("Asia/Kolkata");

header('Access-Control-Allow-Origin: *');
if(isset($_GET['din']) ) {


    $api_key = clean($_GET['din']);
	
	$status = clean($_GET['status']);

    $date = clean(date("Y-m-d H:i:s"));

    Include("../../includes/connection.php");

        $sqlValidate = "select * from devices where door_status=1 AND din='$api_key'";
        $resValidate = mysqli_query($conn, $sqlValidate);

        if (mysqli_num_rows($resValidate) > 0) {

	if($status == 0)
	{
            $sqlInsert = "UPDATE `devices` SET `door_status`= 0 WHERE din='$api_key'";

            mysqli_query($conn, $sqlInsert);
	}
        
            $json_array['door_status'] = "Open";
            $json_response = json_encode($json_array);
            echo $json_response;




    } else {
        //Parameters missing

        $json_array['door_status'] = "Closed";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameter Missing !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
?>
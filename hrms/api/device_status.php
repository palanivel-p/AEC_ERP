<?php
date_default_timezone_set("Asia/Kolkata");

header('Access-Control-Allow-Origin: *');
if(isset($_GET['battery_percentage'])&&isset($_GET['status'])&&isset($_GET['api_key']) ) {
    $battery = clean($_GET['battery_percentage']);
    $status = clean($_GET['status']);
    $api_key = clean($_GET['api_key']);

    $date = clean(date("Y-m-d H:i:s"));

    Include("../../includes/connection.php");

        $sqlValidate = "select * from devices where api_key='$api_key' ";
        $resValidate = mysqli_query($conn, $sqlValidate);

        if (mysqli_num_rows($resValidate) > 0) {


            $sqlInsert = "UPDATE `devices` SET `percentage`='$battery', `status`='$status',`updated_dt`='$date' WHERE api_key='$api_key'";

            mysqli_query($conn, $sqlInsert);



            $id = array();

            $sql = "SELECT * FROM staff WHERE access_status!=1";
            $result = mysqli_query($conn, $sql);



            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $staff_id = $row['staff_id']; // Changed variable name to avoid conflict with $id
                    $id[] = $staff_id;

                    // Adjusted the URL for images

                }
            }



            $json_array['status'] = "success";
            $json_array['msg'] = "success";
            $json_array['id'] = $id;
            $json_response = json_encode($json_array);
            echo $json_response;




    } else {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "invalid device !!!";
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
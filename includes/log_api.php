<?php
Include("connection.php");
date_default_timezone_set("Asia/Kolkata");

header('Access-Control-Allow-Origin: *');
if(isset($_GET['staff_id'])&&isset($_GET['role']) ) {
    $message = clean($_GET['message']);
    $role = clean($_GET['role']);
    $staff_id = clean($_GET['staff_id']);
    $staff_name = clean($_GET['staff_name']);
    $date = clean(date("Y-m-d H:i:s"));

     $sqlInsert = "INSERT INTO `user_activity`(`id`, `role`, `user_name`, `activity`, `added_date`) VALUES ('','$role','$staff_name','$message','$date')";
    mysqli_query($conn, $sqlInsert);


    $endOfCycle = date('Y-m-d H:i:s', strtotime("-3 months")); // Adjusted format to include time
    $sqlquery = "DELETE FROM user_activity WHERE date_time <= '$endOfCycle'";
    $result = mysqli_query($conn, $sqlquery);


    $json_array['status'] = "success";
    $json_array['msg'] = "success";
    $json_response = json_encode($json_array);
    echo $json_response;

}
else{
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
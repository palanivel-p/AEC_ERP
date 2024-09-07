<?php
Include("../../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

if(isset($_POST['payroll_id'])) {

    $payroll_month = clean($_POST['payroll_month']);
    $no_days = clean($_POST['no_days']);
    $payroll_id = clean($_POST['payroll_id']);


    $date = date("Y-m-d H:i:s");



    $sqlInsert = "UPDATE `payroll_month` SET `payroll_month` = '$payroll_month',`payroll_days` = '$no_days' WHERE `payroll_id` = '$payroll_id'";
    mysqli_query($conn, $sqlInsert);







    $json_array['status'] = "success";
    $json_array['msg'] = "Thank You !!!";

    $json_response = json_encode($json_array);
    echo $json_response;



}
else
{
    //Parameters missing


    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameters Missing !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}




function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}


?>
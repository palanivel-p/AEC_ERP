<?php
Include("../../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

if(isset($_GET['emp_id']) && isset($_GET['type'])&& isset($_GET['api_key'])) {

    $emp_id = clean($_GET['emp_id']);

    $type = clean($_GET['type']);

    
    $datee = date("Y-m-d");
    $date = date("Y-m-d H:i:s");
    $dates = date("Y-m-d 0:0:0");
    $api_key = clean($_GET['api_key']);
    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {

        if($type=="breakOut") {

            $sqlInsert = "insert into `break_attendance`(`emp_id`,`date`,`break_out`,`status_type`) values ('$emp_id','$datee','$date','Break')";
            mysqli_query($conn, $sqlInsert);
        }
        elseif($type=="breakIn") {

            $sqlquerys = "select * from break_attendance  WHERE emp_id='$emp_id' AND  date = '$dates' order by id desc limit 1";
            $results = mysqli_query($conn, $sqlquerys);

            if (mysqli_num_rows($results) == 1) {


                $row = mysqli_fetch_array($results);

                if($row['break_in']=='0000-00-00 00:00:00') {

                    $sqlInsert = "UPDATE `break_attendance` SET `break_in`='$date' WHERE emp_id='$emp_id' order by id desc limit 1";
                    mysqli_query($conn, $sqlInsert);
                }

                $sqlUpdate = "UPDATE `devices` SET `door_status` ='1' WHERE api_key='$api_key'";
                mysqli_query($conn, $sqlUpdate);


            } else {
                $json_array['status'] = "failure";
                $json_array['msg'] = "Breakout is missing";
                $json_response = json_encode($json_array);
                echo $json_response;
                exit;

            }
        }

        $json_array['status'] = "success";
        $json_array['msg'] = "Thank You !!!";

        $json_response = json_encode($json_array);
        echo $json_response;


    } else {
        //device missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "invalid device";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
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
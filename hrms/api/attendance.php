<?php
Include("../../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

if(isset($_GET['emp_id']) && isset($_GET['type'])&& isset($_GET['api_key'])) {

    $emp_id = clean($_GET['emp_id']);

    $type = clean($_GET['type']);
    $lat = '12.924860543828062';
    $lng = '80.11271666932089';
    $datee = date("Y-m-d H:i:s");

    $date = date("Y-m-d ");
    $dates = date("Y-m-d 0:0:0");
    $api_key = clean($_GET['api_key']);
    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {




            if ($type == "logIn") {

                $sqlqueryss = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND login >= '$dates' ORDER BY login DESC ";
                $resultss = mysqli_query($conn, $sqlqueryss);

                $sqlUpdate = "UPDATE `devices` SET `door_status` ='1' WHERE api_key='$api_key'";
                mysqli_query($conn, $sqlUpdate);

                if (mysqli_num_rows($resultss) == 0) {

                    $sqlInsert = "insert into `attendance`(`emp_id`,`date_time`,`login_lat`,`login_lng`,`login`,`present_status`,`remarks`) values ('$emp_id','$date','$lat','$lng','$datee','A','self')";
                    mysqli_query($conn, $sqlInsert);



                    $sqlUpdates = "UPDATE `staff` SET `daily_status`='1' WHERE `staff_id`='$emp_id'";
                    mysqli_query($conn, $sqlUpdates);


            }

            } elseif ($type == "logOut") {

                $sqlquerys = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND login >= '$dates' ORDER BY login DESC ";
                $results = mysqli_query($conn, $sqlquerys);

                if (mysqli_num_rows($results) > 0) {

                    $row = mysqli_fetch_array($results);

                    $logintym = strtotime($row['login']);
                    $current_time = time();

//                    $duration = $current_time - $logintym;
//
//                    $hours = floor($duration / 3600);
//                    $minutes = floor(($duration % 3600) / 60);
//                    $seconds = $duration % 60;
//                    :
//                    $totaltym = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);




                    $logTime = date("H:i:s", strtotime($row['login']));
                    $currentTime = date("Y-m-d H:i:s");
                    $a = date("H:i:s", strtotime($currentTime));

                    $aa = strtotime($a);
                    $bb = strtotime($logTime);

                    $diff = $aa - $bb;

                     $formattedDiff = gmdate("H:i:s", abs($diff));











if($row['logout']=='0000-00-00 00:00:00') {

    $sqlInsert = "UPDATE `attendance` SET `logout`='$datee',`present_status`='P',`duration`='$formattedDiff',`logout_lat`='$lat',`logout_lng`='$lng' WHERE emp_id='$emp_id' order by id desc limit 1";
    mysqli_query($conn, $sqlInsert);


//    $sqlUpdates = "UPDATE `staff` SET `daily_status`='0' WHERE `staff_id`='$emp_id'";
//    mysqli_query($conn, $sqlUpdates);
}

                } else {
                    $json_array['status'] = "failure";
                    $json_array['msg'] = "login is missing";
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
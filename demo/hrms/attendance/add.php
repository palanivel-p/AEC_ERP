<?php
Include("../../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

if(isset($_POST['id']) && isset($_POST['type'])&& isset($_POST['date'])&& isset($_POST['hours'])) {

    $emp_id = clean($_POST['id']);

    $type = clean($_POST['type']);
    $lat = '12.924860543828062';
    $lng = '80.11271666932089';
    $datee = date("Y-m-d H:i:s");

    $formattedDate = clean($_POST['date']);
    $date = date('Y-m-d', strtotime($formattedDate));

    $hours = clean($_POST['hours']);
    $minutes = clean($_POST['minutes']);
    $sec = '00';

    $period = clean($_POST['period']);

    if ($period == 'AM') {
        $hours = ($hours == 12) ? '00' : $hours;
    } elseif ($period == 'PM') {
        $hours = ($hours == 12) ? '12' : ($hours + 12);
    }

    $time = sprintf("%02d:%02d:00", $hours, $minutes);


    $inhours = clean($_POST['inhours']);
    $inminutes = clean($_POST['inminutes']);
    $insec = '00';

    $inperiod = clean($_POST['inperiod']);

    if ($inperiod == 'AM') {
        $inhours = ($inhours == 12) ? '00' : $inhours;
    } elseif ($inperiod == 'PM') {
        $inhours = ($inhours == 12) ? '12' : ($inhours + 12);
    }

    $intime = sprintf("%02d:%02d:00", $inhours, $inminutes);





    $indateTimeFormat = $date . ' ' . $intime;




    $dateTimeFormat = $date . ' ' . $time;

    $sqlquery = "select * from staff where `staff_id`='$emp_id'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {

        if($type=="logIn") {

                $sqlInsert = "Insert into `attendance`(`emp_id`,`date_time`,`login`,`present_status`,`remarks`,`logout`,`duration`) values ('$emp_id','$date','$indateTimeFormat','A','HR','0000-00-00 00:00:00','0')";
            mysqli_query($conn, $sqlInsert);



//            $eid=$_COOKIE['emp_id'];
//            $info = urlencode("Login manually successfully");
//            $eid = urlencode($eid);
//
//            $url = "https://gbtc.officetime.in/include/activity_log.php?message=$info&emp_id=$eid";
//
//            file_get_contents($url);

        }
        elseif($type=="logOut") {

            $sqlquerys = "SELECT * FROM attendance WHERE emp_id = '$emp_id' AND date_time = '$date' ORDER BY login DESC";
            $results = mysqli_query($conn, $sqlquerys);

            if (mysqli_num_rows($results) > 0) {

                $row = mysqli_fetch_array($results);

                $logintym = $row['login']; // Assuming $logintym is a string representing the login time
                $current_time = $dateTimeFormat; // Assuming $current_time is a string representing the current time

                $logintym = strtotime($logintym); // Convert login time to a Unix timestamp
                $current_time = strtotime($current_time); // Get the current time as a Unix timestamp

                $duration = $current_time - $logintym; // Calculate the duration in seconds

// You can convert the duration to a more human-readable format, for example, in hours, minutes, and seconds
                $hours = floor($duration / 3600);
                $minutes = floor(($duration % 3600) / 60);
                $seconds = $duration % 60;

// Construct a human-readable duration string in HH:MM:SS format
                $totaltym = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);



                $logTime = date("H:i:s", strtotime($row['login']));
                $currentTime = date("Y-m-d H:i:s");
                $a = date("H:i:s", strtotime($dateTimeFormat));

                $aa = strtotime($a);
                $bb = strtotime($logTime);

                $diff = $aa - $bb;

                $formattedDiff = gmdate("H:i:s", abs($diff));



                $sqlInsert = "UPDATE `attendance` SET `logout`='$dateTimeFormat',`present_status`='P',`duration`='$formattedDiff' WHERE emp_id='$emp_id' order by id desc limit 1";
                mysqli_query($conn, $sqlInsert);


//                $sqlUpdates = "UPDATE `staff` SET `daily_status`='0' WHERE `staff_id`='$emp_id'";
//                mysqli_query($conn, $sqlUpdates);




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
        $json_array['msg'] = "invalid Employee ID";
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
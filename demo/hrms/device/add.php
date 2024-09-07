<?php
Include("../../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

if(isset($_POST['dname']) && isset($_POST['dinput'])) {

    $dname = $_POST['dname'];

    $dinput = $_POST['dinput'];

    $date = date("Y-m-d H:i:s");


    $sqlquery = "select * from devices where `din`='$dinput'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) == 0) {

        $api_output = null;

        for ($loop = 0; $loop <= 14; $loop++) {
            for ($isRandomInRange = 0; $isRandomInRange === 0;) {
                $isRandomInRange = isRandomInRange(findRandom());
            }

            $dapi .= html_entity_decode('&#' . $isRandomInRange . ';');
        }


        $sqlInsert = "INSERT INTO `devices` (`din`, `device_name`, `api_key`, `added_dt`, `percentage`, `status`, `updated_dt`, `door_status`) 
              VALUES ('$dinput', '$dname', '$dapi', '$date', '', '','0000-00-00 00:00:00', '0')";

        $result = mysqli_query($conn, $sqlInsert);









        $json_array['status'] = "success";
        $json_array['msg'] = "Thank You !!!";

        $json_response = json_encode($json_array);
        echo $json_response;


    } else {
        //device missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Device ID Already registered";
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





function isRandomInRange($mRandom) {
    if(($mRandom >=58 && $mRandom <= 64) ||
        (($mRandom >=91 && $mRandom <= 96))) {
        return 0;
    } else {
        return $mRandom;
    }
}

function findRandom() {
    $mRandom = rand(48, 122);
    return $mRandom;
}
?>
<?php
Include("../../includes/connection.php");

header('Access-Control-Allow-Origin: *');

if(isset($_POST['package'])&&isset($_POST['license'])) {
    $package = $_POST['package'];
    $license = $_POST['license'];

    $sqlquery = "select * from `face_license`";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {


        $sqlUpdates = "UPDATE `face_license` SET `package_name`='$package',`license_key`='$license' WHERE `id`=1";
        mysqli_query($conn, $sqlUpdates);


        $eid = $_COOKIE['emp_id'];
        $info = urlencode("License Key updated");
        $eid = urlencode($eid); // Assuming $id is a variable with the emp_id value

        $url = "https://gbtc.officetime.in/include/activity_log.php?message=$info&emp_id=$eid";

        file_get_contents($url);

        $json_array['status'] = "success";
        $json_array['msg'] = "updated successfully";
        $json_response = json_encode($json_array);
        echo $json_response;
        exit;

    }else{
        $json_array['status'] = "failure";
        $json_array['msg'] = "failure";
        $json_response = json_encode($json_array);
        echo $json_response;
        exit;
    }
} else {
    //not upload
    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameter Missing";
    $json_response = json_encode($json_array);
    echo $json_response;
}


?>
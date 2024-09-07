<?php
Include("../../includes/connection.php");
//Include('../include/admin_access.php');
//Include('../include/log_check.php');
header('Access-Control-Allow-Origin: *');


$id = $_COOKIE["emp_id"];

$Cname='GBTC';

$uploadDir = '../image/';
$new_image_name = $Cname . '.png';

//        $uploadDirPdf = '../../placements/pdf/';
//        $new_image_name_pdf = $career_id.'.pdf';


$maxSize = 1000000;

$uploadedFile = '';
if (!empty($_FILES["profile"]["tmp_name"])) {


    if (($_FILES['profile']['size']) <= $maxSize) {

        $targetFilePath = $uploadDir . $new_image_name;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('png', 'png');
        if (in_array($fileType, $allowTypes)) {

            if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFilePath)) {

                //not uploaded
                $json_array['status'] = "failure";
                $json_array['msg'] = "logo not updated!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            } else {


                $json_array['status'] = "success";
                $json_array['msg'] = "Logo updated !!!";
                $json_response = json_encode($json_array);
                echo $json_response;

                $info = urlencode("Device Logo changed");
                $id = urlencode($id); // Assuming $id is a variable with the emp_id value

                $url = "https://gbtc.officetime.in/include/activity_log.php?message=$info&emp_id=$id";

                file_get_contents($url);

            }

        } else {
            //allow type
            $json_array['status'] = "failure";
            $json_array['msg'] = "Logo type not uploaded!!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        }


    } else {
        // max size
        $json_array['status'] = "failure";
        $json_array['msg'] = " Logo size not uploaded!!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


} else {
    //not upload
    $json_array['status'] = "failure";
    $json_array['msg'] = "Logo not uploaded!!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}




?>
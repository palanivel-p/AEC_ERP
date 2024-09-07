<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['time_stamp'])) {

    $time_stamp = $_POST['time_stamp'];

    $gallery_id = $time_stamp;

    $uploadDir = '../time_stamp/';
    $new_image_name = $gallery_id . '.jpg';


    $uploadedFile = '';
    if (!empty($_FILES["upload_image"]["name"])) {


//                if (($_FILES['upload_image']['size']) <= $maxSize) {

        $targetFilePath = $uploadDir . $new_image_name;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'jpeg');
        if (in_array($fileType, $allowTypes)) {

            if (!move_uploaded_file($_FILES["upload_image"]["tmp_name"], $targetFilePath)) {

//not uploaded
                $json_array['status'] = "failure";
                $json_array['msg'] = "Image not uploadedddd!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            } else {

                $json_array['status'] = "success";
                $json_array['msg'] = "Added Successfully !!!";
                $json_response = json_encode($json_array);
                echo $json_response;


            }
        } else {
            //allow type
            $json_array['status'] = "failure";
            $json_array['msg'] = "change Image type not uploaded!!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        }


//                }
//                else {
//                    // max size
//                    $json_array['status'] = "failure";
//                    $json_array['msg'] = "change Image size not uploaded!!!";
//                    $json_response = json_encode($json_array);
//                    echo $json_response;
//                }


    } else {
        //not upload
        $json_array['status'] = "failure";
        $json_array['msg'] = "Image not uploaded!!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


}

?>
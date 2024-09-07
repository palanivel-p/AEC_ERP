
<?php
//header('Access-Control-Allow-Origin: *');

Include("../../includes/connection.php");
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['name']) && isset($_POST['id'])&& isset($_POST['api_key'])) {

    $name = clean($_POST['name']);
    $emp_id = clean($_POST['id']);



    $api_key = clean($_POST['api_key']);
    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {
        $sqlValidate = "SELECT * FROM `staff` WHERE staff_id='$emp_id' AND staff_name='$name'";
        $resValidate = mysqli_query($conn, $sqlValidate);

        if (mysqli_num_rows($resValidate)>0) {


            $gallery_id = $emp_id;

            $uploadDir = '../employee_img/';
            $new_image_name = $gallery_id . '.jpg';

//        $uploadDirPdf = '../../placements/pdf/';
//        $new_image_name_pdf = $career_id.'.pdf';


            $maxSize = 2000000;

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
                            $json_array['msg'] = "Image not uploaded!!!";
                            $json_response = json_encode($json_array);
                            echo $json_response;
                        } else {
                            $sqlUpdates = "UPDATE staff SET img =1 WHERE staff_id ='$emp_id'";
                            mysqli_query($conn, $sqlUpdates);


//                        $info = urlencode("Added Gallery" );
//                        file_get_contents($website . "portal/includes/log.php?emp_id=$emp_role&info=$info");


                            $json_array['status'] = "success";
                            $json_array['msg'] = "Added Successfully !!!";
                            $json_response = json_encode($json_array);
                            echo $json_response;


                        }
                    }
                    else {
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




            }
            else {
                //not upload
                $json_array['status'] = "failure";
                $json_array['msg'] = "Image not uploaded!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            }

        } else {

            $json_array['status'] = "failure";
             $json_array['msg'] = "invalid login ";
            $json_response = json_encode($json_array);
            echo $json_response;

        }
    } else {
        $json_array['status'] = "failure";
        $json_array['msg'] = "invalid device";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
}
            else
            {
                $json_array['status']="failure";
                $json_array['msg']="Parameters Missing";
                $json_response=json_encode($json_array);
                echo $json_response;
            }




            function clean($data) {
                $data= str_replace("'","",$data);
                $data= str_replace('"',"",$data);
                return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            }


            ?>
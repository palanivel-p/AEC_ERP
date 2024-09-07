<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['service_id']))
{
    Include("../includes/connection.php");

    $service_id = $_POST['service_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $visit_date = $_POST['visit_date'];
    $customer_name = $_POST['customer_name'];
    $meet = $_POST['meet'];
    $service_type = $_POST['service_type'];
    $discuss_about = $_POST['discuss_about'];
    $mobile = $_POST['mobile'];;
    $material_name = $_POST['material_name'];
    $qty = $_POST['qty'];
    $progress = $_POST['progress'];
    $last_follow = $_POST['last_follow'];
    $next_follow = $_POST['next_follow'];

    $date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];


    $added_by = $_COOKIE['user_id'];
//    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `service` WHERE service_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($service_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `service` SET `service_id`='$service_id',`visit_date`='$visit_date',`customer_name`='$customer_name',`meet_whom`='$meet',`mobile`='$mobile',`discuss_about`='$discuss_about',`service_type`='$service_type',`next_follow`='$next_follow' WHERE `service_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);

// Image upload process
            $uploadDir = 'service_img/';

// Loop through each image
            for ($i = 1; $i <= 5; $i++) {
                $fileInputName = "upload_img" . $i;
                $new_image_name = $service_id . '_' . $i . '.jpg';

                if (!empty($_FILES[$fileInputName]["name"])) {
                    $targetFilePath = $uploadDir . $new_image_name;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    $allowTypes = array('jpg', 'jpeg', 'png');

                    if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)) {
                            $sqlUpdates = "UPDATE service SET img = 1 WHERE service_id ='$service_id'";
                            mysqli_query($conn, $sqlUpdates);
                        } else {
                            $json_array['status'] = "error";
                            $json_array['msg'] = "Image upload failed!";
                            echo json_encode($json_array);
                            exit;
                        }
                    } else {
                        $json_array['status'] = "error";
                        $json_array['msg'] = "Only JPG, JPEG, and PNG files are allowed!";
                        echo json_encode($json_array);
                        exit;
                    }
                }
            }

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated Successfully!";
            echo json_encode($json_array);



        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "service ID Is Not Valid";
            $json_response = json_encode($json_array);
            echo $json_response;
        }
    }
    else
    {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Login !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }

}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}

?>

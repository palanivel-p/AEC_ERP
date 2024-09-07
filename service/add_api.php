<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['visit_date'])&& isset($_POST['customer_name'])) {
    Include("../includes/connection.php");

    $visit_date = clean($_POST['visit_date']);
    $customer_name = clean($_POST['customer_name']);
    $meet = $_POST['meet'];
    $service_type = $_POST['service_type'];
    $discuss_about = $_POST['discuss_about'];
    $mobile = $_POST['mobile'];
    $qty = $_POST['qty'];
    $progress = $_POST['progress'];
    $last_follow = $_POST['last_follow'];
    $next_follow = $_POST['next_follow'];

    $date = date('Y-m-d');
//    $added_by = $_COOKIE['user_id'];
    $api_key = $_COOKIE['panel_api_key'];

    $added_by = $_COOKIE['user_id'];
//    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {

        $sqlInsert = "INSERT INTO `service`(`service_id`, `visit_date`,`customer_name`,`meet_whom`,`mobile`,`discuss_about`,`service_type`,`next_follow`,`added_by`) 
                                            VALUES ('','$visit_date','$customer_name','$meet','$mobile','$discuss_about','$service_type','$next_follow','$added_by')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $service_id="SV".($ID);

        $sqlUpdate = "UPDATE service SET service_id = '$service_id' WHERE id ='$ID'";
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
                        $sqlUpdates = "UPDATE service SET img" . $i . " = 1 WHERE service_id ='$service_id'";
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
        $role=$_COOKIE['role'];
        $staff_id=$_COOKIE['user_id'];
        $staff_name=$_COOKIE['user_name'];
        $info = urlencode("Service Added");
        $role = urlencode($role); // Assuming $id is a variable with the emp_id value
        $staff_id = urlencode($staff_id); // Assuming $id is a variable with the emp_id value
        $staff_name = urlencode($staff_name); // Assuming $id is a variable with the emp_id value
        $url = "https://erp.aecindia.net/includes/log_api.php?message=$info&role=$role&staff_id=$staff_id&staff_name=$staff_name";
        file_get_contents($url);


        $json_array['status'] = "success";
        $json_array['msg'] = "Added Successfully!";
        echo json_encode($json_array);


    }


    else {
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



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>

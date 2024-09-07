<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['user_id']))
{
    Include("../../includes/connection.php");

    $user_id = $_POST['user_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $Phone = $_POST['Phone'];
    $role = $_POST['role'];
//    $warehouse = $_POST['warehouse'];
    $access_status = $_POST['active_status'];

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

        $sqlValidate = "SELECT * FROM `user` WHERE user_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($user_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `user` SET `user_id`='$user_id',`f_name`='$first_name',`l_name`='$last_name',`username`='$user_name',`email`='$email',`password`='$password',`phone`='$Phone',`role`='$role',`access_status`='$access_status' WHERE `user_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);


            $uploadDir = 'user_img/';
            $new_image_name = $user_id.'.jpg';

//            $uploadDirPdf = '../../placements/pdf/';
//            $new_image_name_pdf = $team_id.'.pdf';

            $maxSize =1000000;
            $uploadedFile = '';
            if (!empty($_FILES["upload_image"]["tmp_name"])) {
                // If a new image is provided, delete the old one first
                if (file_exists($uploadDir . $new_image_name)) {
                    unlink($uploadDir . $new_image_name);
                }
                if(($_FILES['upload_image']['size']) <= $maxSize) {

                    $targetFilePath = $uploadDir . $new_image_name;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg','jpeg','png');
                    if (in_array($fileType, $allowTypes)) {

                        if (!move_uploaded_file($_FILES["upload_image"]["tmp_name"], $targetFilePath)) {

//not uploaded
                            $json_array['status'] = "success";
                            $json_array['msg'] = "Updated Successfully, but Image not uploaded!!!";
                            $json_response = json_encode($json_array);
                            echo $json_response;
                        }
                        else{
                            $sqlUpdates = "UPDATE `user` SET img =1 WHERE user_id ='$user_id'";
                            mysqli_query($conn, $sqlUpdates);

                            // $emp_id = $_COOKIE['staff_id'];
                            // $emp_role = $_COOKIE['role'];
//                            $info = urlencode("Edited Gallery" );
//                            file_get_contents($website . "portal/includes/log.php?emp_id=$emp_role&info=$info");


                            $uploadDir = 'user_doc/';
                            $new_pdf_name=$user_id.'1.pdf';

                            if (!empty($_FILES["upload_doc1"]["tmp_name"])) {
                                if(($_FILES['upload_doc1']['size']) <= $maxSize) {
                                    $targetFilePath = $uploadDir . $new_pdf_name;
                                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                                    $allowTypes = array('pdf'); // Allow only PDF files
                                    if (in_array($fileType, $allowTypes)) {
                                        if (!move_uploaded_file($_FILES["upload_doc1"]["tmp_name"], $targetFilePath)) {
                                            // File not uploaded
                                            $json_array['status'] = "error";
                                            $json_array['msg'] = "PDF file upload failed!";
                                        } else {
                                            // File uploaded successfully
                                            $sqlUpdates = "UPDATE user SET doc1 =1 WHERE user_id ='$user_id'";
                                            mysqli_query($conn, $sqlUpdates);

                                            $json_array['status'] = "success";
                                            $json_array['msg'] = "PDF file uploaded successfully!";
                                        }
                                    }
                                }
                            }


                            $new_pdf_name=$user_id.'2.pdf';

                            if (!empty($_FILES["upload_doc2"]["tmp_name"])) {
                                if(($_FILES['upload_doc2']['size']) <= $maxSize) {
                                    $targetFilePath = $uploadDir . $new_pdf_name;
                                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                                    $allowTypes = array('pdf'); // Allow only PDF files
                                    if (in_array($fileType, $allowTypes)) {
                                        if (!move_uploaded_file($_FILES["upload_doc2"]["tmp_name"], $targetFilePath)) {
                                            // File not uploaded
                                            $json_array['status'] = "error";
                                            $json_array['msg'] = "PDF file upload failed!";
                                        } else {
                                            // File uploaded successfully
                                            $sqlUpdates = "UPDATE user SET doc2 =1 WHERE user_id ='$user_id'";
                                            mysqli_query($conn, $sqlUpdates);

                                            $json_array['status'] = "success";
                                            $json_array['msg'] = "PDF file uploaded successfully!";
                                        }
                                    }
                                }
                            }


                            $new_pdf_name=$user_id.'3.pdf';

                            if (!empty($_FILES["upload_doc3"]["tmp_name"])) {
                                if(($_FILES['upload_doc3']['size']) <= $maxSize) {
                                    $targetFilePath = $uploadDir . $new_pdf_name;
                                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                                    $allowTypes = array('pdf'); // Allow only PDF files
                                    if (in_array($fileType, $allowTypes)) {
                                        if (!move_uploaded_file($_FILES["upload_doc3"]["tmp_name"], $targetFilePath)) {
                                            // File not uploaded
                                            $json_array['status'] = "error";
                                            $json_array['msg'] = "PDF file upload failed!";
                                        } else {
                                            // File uploaded successfully
                                            $sqlUpdates = "UPDATE user SET doc3 =1 WHERE user_id ='$user_id'";
                                            mysqli_query($conn, $sqlUpdates);

                                            $json_array['status'] = "success";
                                            $json_array['msg'] = "PDF file uploaded successfully!";
                                        }
                                    }
                                }
                            }



                            $new_pdf_name=$user_id.'4.pdf';

                            if (!empty($_FILES["upload_doc4"]["tmp_name"])) {
                                if(($_FILES['upload_doc4']['size']) <= $maxSize) {
                                    $targetFilePath = $uploadDir . $new_pdf_name;
                                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                                    $allowTypes = array('pdf'); // Allow only PDF files
                                    if (in_array($fileType, $allowTypes)) {
                                        if (!move_uploaded_file($_FILES["upload_doc4"]["tmp_name"], $targetFilePath)) {
                                            // File not uploaded
                                            $json_array['status'] = "error";
                                            $json_array['msg'] = "PDF file upload failed!";
                                        } else {
                                            // File uploaded successfully
                                            $sqlUpdates = "UPDATE user SET doc4 =1 WHERE user_id ='$user_id'";
                                            mysqli_query($conn, $sqlUpdates);

                                            $json_array['status'] = "success";
                                            $json_array['msg'] = "PDF file uploaded successfully!";
                                        }
                                    }
                                }
                            }



                            $new_pdf_name=$user_id.'5.pdf';

                            if (!empty($_FILES["upload_doc5"]["tmp_name"])) {
                                if(($_FILES['upload_doc5']['size']) <= $maxSize) {
                                    $targetFilePath = $uploadDir . $new_pdf_name;
                                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                                    $allowTypes = array('pdf'); // Allow only PDF files
                                    if (in_array($fileType, $allowTypes)) {
                                        if (!move_uploaded_file($_FILES["upload_doc5"]["tmp_name"], $targetFilePath)) {
                                            // File not uploaded
                                            $json_array['status'] = "error";
                                            $json_array['msg'] = "PDF file upload failed!";
                                        } else {
                                            // File uploaded successfully
                                            $sqlUpdates = "UPDATE user SET doc5 =1 WHERE user_id ='$user_id'";
                                            mysqli_query($conn, $sqlUpdates);

                                            $json_array['status'] = "success";
                                            $json_array['msg'] = "PDF file uploaded successfully!";
                                        }
                                    }
                                }
                            }






                            $json_array['status'] = "success";
                            $json_array['msg'] = "Updated Successfully!!!";
                            $json_response = json_encode($json_array);
                            echo $json_response;
                        }

                    }
                    else {
                        //allow type
                        $json_array['status'] = "success";
                        $json_array['msg'] = "Updated Successfully,change Image type not uploaded!!!";
                        $json_response = json_encode($json_array);
                        echo $json_response;
                    }

                }
                else {
                    // max size
                    $json_array['status'] = "success";
                    $json_array['msg'] = "Updated Successfully,change Image size not uploaded!!!";
                    $json_response = json_encode($json_array);
                    echo $json_response;
                }

            }
            else {
                //not upload
                $json_array['status'] = "success";
                $json_array['msg'] = "Updated Successfully, but Image not uploaded!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            }




        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "User ID Is Not Valid";
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

function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

?>

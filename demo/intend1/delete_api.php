<?php
if(isset($_POST['intend_id']))
{
    Include("../includes/connection.php");


    $intend_id = $_POST['intend_id'];
    $api_key = $_COOKIE['panel_api_key'];


    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {


        $sqlUpdate = "DELETE FROM `intend` WHERE intend_id='$intend_id'";
        mysqli_query($conn, $sqlUpdate);

          $sqlUpdates = "DELETE FROM `intend_details` WHERE intend_id='$intend_id'";
        mysqli_query($conn, $sqlUpdates);
        //deleted successfully

        $json_array['status'] = "success";
        $json_array['msg'] = "Deleted successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;


    }
    else
    {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Please try after sometime!!!";
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

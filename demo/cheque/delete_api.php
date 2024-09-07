<?php
if(isset($_POST['cheque_id']))
{
    Include("../includes/connection.php");


    $cheque_id = $_POST['cheque_id'];
    $api_key = $_COOKIE['panel_api_key'];


    $added_by = $_COOKIE['user_id'];
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {


        $sqlUpdate = "DELETE FROM `cheque` WHERE cheque_id='$cheque_id'";
        mysqli_query($conn, $sqlUpdate);

        $sqlDelete = "DELETE FROM `cheque_list` WHERE cheque_id='$cheque_id'";
        mysqli_query($conn, $sqlDelete);
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

<?php
header('Access-Control-Allow-Origin: *');

if(isset($_POST['id'])){

    $id =$_POST['id'];


    Include("../../includes/connection.php");


    $sqlquery = "SELECT * FROM `holiday_list` WHERE id='$id'";
    $result = mysqli_query($conn,$sqlquery);
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);


        $sqldelete = "DELETE FROM `holiday_list` WHERE id='$id'";
        mysqli_query($conn, $sqldelete);








        $json_array['status'] = 'success';
        $json_response = json_encode($json_array);
        echo $json_response;
    } else
    {
        //staff id already exist
        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid employee ID !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


}
else
{


    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}
?>

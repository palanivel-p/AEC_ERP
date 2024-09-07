<?php
header('Access-Control-Allow-Origin: *');

if(isset($_POST['id'])){

    $id =$_POST['id'];


    Include("../../includes/connection.php");


    $sqlquery = "SELECT * FROM `devices` WHERE id='$id'";
    $result = mysqli_query($conn,$sqlquery);
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);




        $json_array['status'] = 'success';
        $json_array['did'] = $row['din'];
        $json_array['dname'] = $row['device_name'];
        $json_array['id'] = $row['id'];



        $json_response = json_encode($json_array);
        echo $json_response;
    } else
    {
        //staff id already exist
        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Device ID !!!";
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

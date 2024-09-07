<?php


Include("../../includes/connection.php");

header('Access-Control-Allow-Origin: *');
if(isset($_POST['id'])){

    $id =$_POST['id'];



    $sqlquery = "select * from devices where din='$id'";
    $result = mysqli_query($conn,$sqlquery);

    if (mysqli_num_rows($result) > 0){
        $sqlUpdate = "DELETE FROM `devices` WHERE din='$id'";
        mysqli_query($conn,$sqlUpdate);

        $json_array['status']="success";
        $json_array['msg']="deleted successfully";
        $json_response=json_encode($json_array);
        echo $json_response;
    }
    else
    {
        $json_array['status']="failure";
//        $json_array['msg']="Already registered";
        $json_response=json_encode($json_array);
        echo $json_response;
    }
}
else
{
    $json_array['status']="failure";
    $json_array['msg']="parameters missing";
    $json_response=json_encode($json_array);
    echo $json_response;
}
?>
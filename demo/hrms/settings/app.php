<?php
Include("../../includes/connection.php");

header('Access-Control-Allow-Origin: *');

if(isset($_POST['watsapp'])) {

    $watsapp = $_POST['watsapp'];

    $sqlquery = "select * from `whatsapp`";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {


        $sqlUpdates = "UPDATE `whatsapp` SET `url`='$watsapp' WHERE id=1";
        mysqli_query($conn, $sqlUpdates);




        $json_array['status'] = "success";
        $json_array['msg'] = "updated successfully";
        $json_response = json_encode($json_array);
        echo $json_response;
        exit;

    }else{
        $json_array['status'] = "failure";
        $json_array['msg'] = "failure";
        $json_response = json_encode($json_array);
        echo $json_response;
        exit;
    }
} else {
    //not upload
    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameter Missing";
    $json_response = json_encode($json_array);
    echo $json_response;
}


?>
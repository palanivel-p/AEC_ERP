
<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Kolkata");

Include("../../includes/connection.php");


$sqlValidate = "SELECT * FROM `face_license`;";
$resValidate = mysqli_query($conn, $sqlValidate);

if (mysqli_num_rows($resValidate) > 0) {

    $row=mysqli_fetch_assoc($resValidate);

    $json_array['status'] = "success";
    $json_array['msg'] = "Success !!!";
    $json_array['package_name'] = $row['package_name'];
    $json_array['license_key'] = $row['license_key'];

    $json_response = json_encode($json_array);
    echo $json_response;

} else {
    //staff id already exist

    $json_array['status'] = "failure";
    $json_array['msg'] = "failure !!!";
    $json_array['package_name'] = '';
    $json_array['license_key'] = '';
    $json_response = json_encode($json_array);
    echo $json_response;
}






function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

?>

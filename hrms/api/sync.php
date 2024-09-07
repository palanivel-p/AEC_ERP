<?php
Include("../../includes/connection.php");



if(isset($_GET['api_key'])) {

$api_key = $_GET['api_key'];
$sqlquery = "select * from devices where api_key='$api_key'";
$result = mysqli_query($conn, $sqlquery);

if (mysqli_num_rows($result) > 0) {


    $name = array();
    $id = array();
    $images = array();

//    $sql = "SELECT * FROM staff WHERE office_time_access='staff'";
    $sql = "SELECT * FROM staff WHERE `img`=1 AND `access_status`=1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $staff_id = $row['staff_id']; // Changed variable name to avoid conflict with $id
            $nameDb = $row['staff_name'];
            $name[] = $nameDb;
            $id[] = $staff_id;

            // Adjusted the URL for images
            $images[] = 'https://gbtc.officetime.in/employee_img/' . $staff_id . '.jpg';
        }
    } else {
        die('Error in SQL query: ' . mysqli_error($conn));
    }

    $json_array['status'] = "success";
    $json_array['msg'] = " success";
    $json_array['images'] = $images;
    $json_array['name'] = $name;
    $json_array['id'] = $id;
    $json_response = json_encode($json_array);

    if ($json_response === false) {
        die('Error in JSON encoding: ' . json_last_error_msg());
    }

    echo $json_response;

} else {
        $json_array['status'] = "failure";
        $json_array['msg'] = "invalid device";
         $json_array['images'] = "";
          $json_array['name'] = "";
         $json_array['id'] = "";
        $json_response = json_encode($json_array);
        echo $json_response;
    } 
}
else {
    $json_array['status'] = "failure";
    $json_array['msg'] = " failure";
    $json_array['images'] = "";
    $json_array['name'] = "";
    $json_array['id'] = "";
    $json_response = json_encode($json_array);
    echo $json_response;
}
?>

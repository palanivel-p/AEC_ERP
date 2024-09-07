<?php
Include("../../includes/connection.php");


if(isset($_GET['api_key'])) {

    $api_key = clean($_GET['api_key']);
    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {


        $name = array();
        $idArray = array(); // Changed variable name to avoid conflict with $id later
        $designation = array();

        $sql = "SELECT * FROM staff WHERE access_status='1'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['staff_id']; // Changed variable name to avoid conflict with $idArray
                $role = $row['role'];
                $nameDb = $row['staff_name'];
                $name[] = $nameDb;
                $idArray[] = $id; // Changed to $idArray to avoid conflict with $id
                $designation[] = $role;
            }
        }

        $json_array = array(
            'status' => "success",
            'msg' => "success",
            'name' => $name,
            'id' => $idArray, // Changed to $idArray to avoid conflict with $id
            'designation' => $designation
        );

        $json_response = json_encode($json_array);
        if ($json_response === false) {
            die(json_last_error_msg());
        }

        echo $json_response;
    } else {
    $json_array['status'] = "failure";
    $json_array['msg'] = "invalid Device";
    $json_array['name'] = " ";
    $json_array['id'] = " ";
    $json_array['designation'] = " ";
    $json_response = json_encode($json_array);
    echo $json_response;
}
}
else {
    $json_array['status'] = "failure";
    $json_array['msg'] = "parameters missing";
    $json_array['name'] = " ";
    $json_array['id'] = " ";
    $json_array['designation'] = " ";
    $json_response = json_encode($json_array);
    echo $json_response;


}


function clean($data)
{
    $data = str_replace("'", "", $data);
    $data = str_replace('"', "", $data);
    $data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    return $data;

}


?>
<?php
header('Access-Control-Allow-Origin: *');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    Include("../../includes/connection.php");

    // Use prepared statement to prevent SQL injection
    $sqlquery = "SELECT * FROM `attendance` WHERE id=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sqlquery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are rows
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);


        $eid=$_COOKIE['emp_id'];
        $info = urlencode("Viewed login attendance data ");
        $eid = urlencode($eid); // Assuming $id is a variable with the emp_id value

        $url = "https://gbtc.officetime.in/include/activity_log.php?message=$info&emp_id=$eid";

        file_get_contents($url);




        $json_array['status'] = 'success';
        $json_array['id'] = $row['emp_id'];
        $json_array['date'] = $row['date_time'];
        $json_array['out'] = $row['logout'];
        $json_array['in'] = $row['login'];
        $json_array['lid'] = $row['id'];
//        $json_array['date'] = date('d-m-y', strtotime($row['date_time']));

//        $json_array['login'] = $row['login'];


        // Close the prepared statement
        mysqli_stmt_close($stmt);

        $json_response = json_encode($json_array);
        echo $json_response;
    } else {
        // Visitor ID not found
        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid  ID !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
} else {
    // No ID provided
    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}
?>

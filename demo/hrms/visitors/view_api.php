<?php
header('Access-Control-Allow-Origin: *');



if (isset($_POST['id'])) {
    $id = $_POST['id'];

    Include("../../includes/connection.php");

    // Use prepared statement to prevent SQL injection
    $sqlquery = "SELECT * FROM `visitor_details` WHERE visitor_id=?";

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


     

        $json_array['status'] = 'success';
        $json_array['id'] = $row['visitor_id'];
        $json_array['name'] = $row['name'];
        $json_array['mobile'] = $row['mobile'];
        $json_array['company'] = $row['company'];
        $json_array['purpose'] = $row['purpose'];
        $json_array['count'] = $row['count'];
        $json_array['to_emp_id'] = $row['to_emp_id'];
        $json_array['visit_dt'] = $row['visit_dt'];

        // Close the prepared statement
        mysqli_stmt_close($stmt);

        $json_response = json_encode($json_array);
        echo $json_response;
    } else {
        // Visitor ID not found
        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid visitor ID !!!";
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


<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Kolkata");

Include("../../includes/connection.php");
if(isset($_GET['id'])&&($_GET['api_key'])) {
    $staff_id = clean($_GET['id']);
    $api_key = clean($_GET['api_key']);

    $date = clean(date("Y-m-d H:i:s"));

    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {



        $sqlValidate = "SELECT * FROM `staff` WHERE staff_id='$staff_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);

        if (mysqli_num_rows($resValidate) > 0) {

            $rows = mysqli_fetch_array($resValidate);
            $staff_name = $rows['staff_name'];


            $json_array['status'] = "success";
            $json_array['emp_name'] = $staff_name;
            $json_array['msg'] = "Success !!!";

            $json_response = json_encode($json_array);
            echo $json_response;

        } else {
            //staff id already exist

            $json_array['status'] = "failure";
            $json_array['emp_name'] = "";
            $json_array['msg'] = "Invalid ID !!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        }


    } else {
        $json_array['status'] = "failure";
        $json_array['emp_name'] = "";
        $json_array['msg'] = "invalid Device";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['emp_name'] = "";
    $json_array['msg'] = "Parameter missing  !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

?>
